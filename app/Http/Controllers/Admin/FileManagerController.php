<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FileManagerController extends Controller
{
    public function index($parent_id = null)
    {
        $data['title'] = 'File Manager';
        $data['parent_id'] = $parent_id ?? null;
        $data['items'] = FileManager::with('children.children.children')->where('parent_id', $parent_id)->get();
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
                if ($model->type === 'image') {
                    $image = $model->name;
                    $path = $model->path;
                    $newFileName = renameImage($image, $path, $name);

                    if ($newFileName) {
                        $model->name = $newFileName;
                    }
                } else {
                    $model->name = $name;
                }

                $model->save();
                Session::flash('success', ucwords($type) . ' updated successfully');
            } else {
                if ($type === 'image') {
                    if ($request->hasFile('images')) {
                        foreach ($request->file('images') as $image) {
                            $imageSize = $image->getSize();
                            // print_r($imageSize); die('here');
                            $imageName = $image->getClientOriginalName();
                            $image->move(public_path('uploads/file-manager'), $imageName);
                            $model = new FileManager();
                            $model->name = $imageName;
                            $model->type = $type;
                            $model->path = 'uploads/file-manager/';
                            $model->parent_id = $parent_id;
                            $model->size = $imageSize;
                            $model->save();

                            Log::info('Saved image: ' . $imageName);
                        }

                        Session::flash('success', 'Images uploaded successfully');
                    }
                } elseif ($type === 'folder') {
                    $model = new FileManager();
                    $model->name = $request->name;
                    $model->type = $type;
                    $model->parent_id = $parent_id;
                    $model->size = 0;
                    $model->save();

                    Session::flash('success', 'Folder created successfully');
                }
            }
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back();
    }
}
