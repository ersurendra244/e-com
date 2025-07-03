<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileManager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class FileManagerController extends Controller
{
    public function index($parent_id = null)
    {
        $data['title'] = 'File Manager';
        $data['parent_id'] = $parent_id ?? null;
        $data['items'] = FileManager::with('children.children.children')->where('parent_id', $parent_id)->where('is_delete', '0')->get();
        $data['breadcrumbs'] = $this->getBreadcrumbs($parent_id);
        // return $data['breadcrumbs'];
        return view('admin.file_manager.index', $data);
    }
    private function getBreadcrumbs($parent_id)
    {
        $breadcrumbs = [];
        while ($parent_id) {
            $folder = FileManager::find($parent_id);
            if ($folder) {
                $breadcrumbs[] = $folder;
                $parent_id = $folder->parent_id;
            } else {
                break;
            }
        }

        return array_reverse($breadcrumbs);
    }

    public function create(Request $request)
    {
        $type = $request->type;
        $item_id = $request->item_id ?? null;
        $parent_id = $request->parent_id ?? null;

        try {
            if ($item_id) {
                $model = FileManager::find($item_id);
                $name = $request->name ?? $model->name;

                if ($model->type === 'file') {
                    $image = $model->name;
                    $path = $model->path;
                    $newFileName = renameImage($image, $path, $name);

                    if ($newFileName) {
                        $model->name = $newFileName;
                    }
                } elseif ($model->type === 'folder') {
                    $newRelativePath = renameFolder($model->path, $name);

                    if ($newRelativePath) {
                        $model->name = $name;
                        $model->path = $newRelativePath;
                    }
                } else {
                    $model->name = $name;
                }

                $model->save();

                Session::flash('success', ucwords($model->type) . ' renamed successfully');
            } else {
                if ($type === 'folder') {
                    $folderName = $request->name;

                    $basePath = 'uploads/file-manager';
                    if ($parent_id) {
                        $parentFolder = FileManager::where('id', $parent_id)->where('type', 'folder')->first();
                        if ($parentFolder) {
                            $basePath = rtrim($parentFolder->path, '/');
                        }
                    }

                    $relativePath = createFolder($folderName, $basePath);

                    $model = new FileManager();
                    $model->name = $folderName;
                    $model->type = $type;
                    $model->path = $relativePath;
                    $model->parent_id = $parent_id;
                    $model->size = 0;
                    $model->save();

                    Session::flash('success', 'Folder created successfully');
                } elseif ($type === 'file') {
                    if ($request->hasFile('files')) {
                        foreach ($request->file('files') as $file) {
                            $fileSize = $file->getSize();
                            $originalName = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $baseName = pathinfo($originalName, PATHINFO_FILENAME);

                            $cleanName = Str::slug($baseName, '_'); // base filename
                            $finalName = $cleanName . '.' . $extension;

                            $parentPath = 'uploads/file-manager';
                            if ($parent_id) {
                                $parentFolder = FileManager::where('id', $parent_id)->where('type', 'folder')->first();
                                if ($parentFolder) {
                                    $parentPath = rtrim($parentFolder->path, '/');
                                }
                            }

                            $fullPath = public_path($parentPath);
                            if (!file_exists($fullPath)) {
                                mkdir($fullPath, 0777, true);
                                chmod($fullPath, 0777);
                            }

                            // ✅ Check for duplicate file and generate a unique name
                            $copyCount = 1;
                            $uniqueName = $finalName;
                            while (File::exists($fullPath . '/' . $uniqueName)) {
                                $uniqueName = $cleanName . '_(' . $copyCount . ').' . $extension;
                                $copyCount++;
                            }

                            // Move file with unique name
                            $file->move($fullPath, $uniqueName);

                            $model = new FileManager();
                            $model->name = $uniqueName;
                            $model->type = $type;
                            $model->path = $parentPath . '/';
                            $model->parent_id = $parent_id;
                            $model->size = $fileSize;
                            $model->save();
                        }

                        Session::flash('success', 'Files uploaded successfully');
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
        return back();
    }
    public function preview($id)
    {
        $data['title'] = 'File Preview';
        $data['subtitle'] = 'File Manager';
        $item = FileManager::findOrFail($id);
        $fullPath = public_path($item->path . $item->name);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $content = file_get_contents($fullPath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        return view('admin.file_manager.file_preview', compact('item', 'content', 'extension') + $data);
    }

    public function saveContent(Request $request, $id)
    {
        $item = FileManager::findOrFail($id);

        $fullPath = public_path($item->path . $item->name);

        if (!file_exists($fullPath)) {
            return response()->json(['success' => false, 'message' => 'File not found.'], 404);
        }

        try {
            file_put_contents($fullPath, $request->input('content'));
            return response()->json(['success' => true, 'message' => 'File saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $modal = FileManager::findOrFail($id);
        if ($modal) {
            if ($modal->type === 'file') {
                removeImage($modal->name, $modal->path);
            } elseif ($modal->type === 'folder') {
                $children = FileManager::where('parent_id', $modal->id)->get();
                foreach ($children as $child) {
                    $this->delete($child->id);
                }
                $folderPath = public_path($modal->path);
                if (file_exists($folderPath) && is_dir($folderPath)) {
                    deleteFolder($folderPath);
                }
            }
            $modal->delete();
            Session::flash('success', ucwords($modal->type) . ' deleted successfully');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
