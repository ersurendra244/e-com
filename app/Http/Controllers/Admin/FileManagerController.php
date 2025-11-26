<?php

namespace App\Http\Controllers\Admin;

use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    public function index($parent_id = null)
    {
        // $data['title'] = 'File Manager - Toggle View';
        // $data['subtitle'] = 'File Manager';
        $data['title'] = 'File Manager';
        $data['parent_id'] = $parent_id ?? null;
        $data['items'] = FileManager::with('children.children.children')->where('parent_id', $parent_id)->where('is_delete', '0')->get();
        $data['breadcrumbs'] = $this->getBreadcrumbs($parent_id);
        // return $data['items'];
        // return view('admin.file_manager.demo', $data);
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
        $parent_id = $request->parent_id ?? null;
        $responseMessage = '';
        $responseSuccess = false;

        try {
            if ($type === 'text') {
                $name = $request->name;
                createFile($name, $parent_id);
                $responseMessage = 'File created successfully';
                $responseSuccess = true;

            } elseif ($type === 'folder') {
                $name = $request->name;
                createFolder($name, $parent_id);
                $responseMessage = 'Folder created successfully';
                $responseSuccess = true;

            } elseif ($type === 'file') {
                if ($request->hasFile('files')) {
                    $uploadedCount = uploadFiles($request->file('files'), $parent_id);
                    $responseMessage = ($uploadedCount > 1 ? 'Files' : 'File') . ' uploaded successfully';
                    $responseSuccess = true;
                } else {
                    throw new \Exception('No files selected for upload.');
                }
            } else {
                throw new \Exception('Invalid operation type.');
            }

            return response()->json(['success' => $responseSuccess, 'message' => $responseMessage]);

        } catch (\Exception $e) {
            Log::error('File Manager Create Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function rename(Request $request)
    {
        $item_id = $request->item_id;
        $newName = $request->name;
        $responseMessage = '';
        $responseSuccess = false;

        try {
            $renamedItem = renameItem($item_id, $newName);
            $responseMessage = ucwords($renamedItem->type) . ' renamed successfully';
            $responseSuccess = true;

            return response()->json(['success' => $responseSuccess, 'message' => $responseMessage]);

        } catch (\Exception $e) {
            Log::error('File Manager Rename Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($item_id)
    {
        $responseMessage = '';
        $responseSuccess = false;
        try {
            deleteItem($item_id);
            $responseMessage = 'Item deleted successfully';
            $responseSuccess = true;

            return response()->json(['success' => $responseSuccess, 'message' => $responseMessage]);
        } catch (\Exception $e) {
            Log::error('File Manager Delete Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
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

    public function edit($id)
    {
        $data['title'] = 'File Preview';
        $data['subtitle'] = 'File Manager';
        $data['mode'] = 'edit';
        $item = FileManager::findOrFail($id);
        $fullPath = public_path($item->path . $item->name);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $content = file_get_contents($fullPath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        return view('admin.file_manager.edit', compact('item', 'content', 'extension') + $data);
    }

    public function view($id)
    {
        $data['title'] = 'File Preview';
        $data['subtitle'] = 'File Manager';
        $data['mode'] = 'view';
        $item = FileManager::findOrFail($id);
        $fullPath = public_path($item->path . $item->name);

        if (!file_exists($fullPath)) {
            abort(404);
        }

        $content = file_get_contents($fullPath);
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);

        return view('admin.file_manager.edit', compact('item', 'content', 'extension') + $data);
    }


}
