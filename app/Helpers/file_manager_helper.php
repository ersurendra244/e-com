<?php

// namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\FileManager;

if (!function_exists('createFile')) {
    function createFile($fileName, $parentId = null)
    {
        if (empty($fileName) || !is_string($fileName)) {
            throw new \Exception('Invalid file name.');
        }

        $basePath = 'uploads/file-manager';
        $parentPath = $basePath;

        // Resolve parent folder path if provided
        if ($parentId) {
            $parentFolder = FileManager::where('id', $parentId)->where('type', 'folder')->first();
            if ($parentFolder) {
                $parentPath = rtrim($parentFolder->path, '/');
            } else {
                throw new \Exception('Parent folder not found.');
            }
        }

        // Prepare full relative and absolute file path
        $relativeFilePath = $parentPath . '/' . $fileName;
        $fullDiskPath = public_path($relativeFilePath);

        if (!file_exists($fullDiskPath)) {
            file_put_contents($fullDiskPath, '');
            chmod($fullDiskPath, 0666);
        }

        $model = new FileManager();
        $model->name = $fileName;
        $model->type = 'text';
        $model->path = rtrim($parentPath, '/') . '/';
        $model->parent_id = $parentId;
        $model->size = filesize($fullDiskPath);
        $model->save();

        return true;
    }
}

if (!function_exists('createFolder')) {
    function createFolder($name, $parentId = null)
    {
        if (empty($name)) {
            throw new \Exception('Folder name cannot be empty.');
        }

        $basePath = 'uploads/file-manager';
        if ($parentId) {
            $parentFolder = FileManager::where('id', $parentId)->where('type', 'folder')->first();
            if ($parentFolder) {
                $basePath = rtrim($parentFolder->path, '/');
            } else {
                throw new \Exception('Parent folder not found.');
            }
        }

        $relativePathWithFolderName = rtrim($basePath, '/') . '/' . $name . '/';
        $fullDiskPath = public_path($relativePathWithFolderName);

        // Check if a folder with the same name already exists on disk
        if (File::exists($fullDiskPath) && File::isDirectory($fullDiskPath)) {
            throw new \Exception("A folder named '{$name}' already exists on disk in this location.");
        }

        // Check if a folder with the same name already exists in the database for this parent
        $existingFolderInDb = FileManager::where('name', $name)
            ->where('path', $relativePathWithFolderName)
            ->where('type', 'folder')
            ->first();
        if ($existingFolderInDb) {
            throw new \Exception("A folder named '{$name}' already exists in the database for this location.");
        }

        // Create directory recursively with 0777 permissions
        if (!File::makeDirectory($fullDiskPath, 0777, true, true)) {
            throw new \Exception('Failed to create folder on disk.');
        }

        $model = new FileManager();
        $model->name = $name;
        $model->type = 'folder';
        $model->path = $relativePathWithFolderName;
        $model->parent_id = $parentId;
        $model->size = 0;
        $model->save();
        return $model;
    }
}

if (!function_exists('uploadFiles')) {
    function uploadFiles(array $files, ?int $parentId = null): int
    {
        if (empty($files)) {
            throw new \Exception('No files provided for upload.');
        }

        $uploadedCount = 0;
        foreach ($files as $file) {
            $fileSize = $file->getSize();
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);

            $cleanName = Str::slug($baseName, '_');
            $finalName = $cleanName . '.' . $extension;

            $parentPath = 'uploads/file-manager';
            if ($parentId) {
                $parentFolder = FileManager::where('id', $parentId)->where('type', 'folder')->first();
                if ($parentFolder) {
                    $parentPath = rtrim($parentFolder->path, '/');
                } else {
                    Log::warning("Parent folder (ID: {$parentId}) not found for file upload. Uploading to base path.");
                }
            }

            $fullPathDir = public_path($parentPath);
            if (!File::exists($fullPathDir)) {
                File::makeDirectory($fullPathDir, 0777, true, true);
            }

            // Check for duplicate file and generate a unique name
            $copyCount = 1;
            $uniqueName = $finalName;
            $dbPathForFile = rtrim($parentPath, '/') . '/'; // Path to be stored in DB for files

            // Loop to ensure both disk and DB uniqueness
            while (
                File::exists($fullPathDir . '/' . $uniqueName) ||
                FileManager::where('name', $uniqueName)
                ->where('path', $dbPathForFile)
                ->where('type', 'file')
                ->exists()
            ) {
                $uniqueName = $cleanName . '_(' . $copyCount . ').' . $extension;
                $copyCount++;
            }

            // Move file with unique name
            if (!$file->move($fullPathDir, $uniqueName)) {
                throw new \Exception('Failed to move uploaded file: ' . $originalName);
            }

            $model = new FileManager();
            $model->name = $uniqueName;
            $model->type = 'file';
            $model->path = $dbPathForFile;
            $model->parent_id = $parentId;
            $model->size = $fileSize;
            $model->save();
            $uploadedCount++;
        }

        return $uploadedCount;
    }
}

if (!function_exists('renameItem')) {
    function renameItem($itemId, $newName)
    {
        if (trim($newName) === '') {
            throw new \Exception('Name cannot be empty.');
        }

        $model = FileManager::find($itemId);

        if (!$model) {
            throw new \Exception('Item not found.');
        }

        if ($model->name === $newName) {
            return $model;
        }


        if ($model->type === 'file' || $model->type === 'text') {
            $oldFileName = $model->name;
            $newFileNameWithExt = trim($newName); // accept full name including extension

            $filePath = public_path($model->path . $oldFileName);
            $newFilePath = public_path($model->path . $newFileNameWithExt);

            $alreadyExists = FileManager::where('name', $newFileNameWithExt)
                ->where('path', $model->path)
                ->where(function ($q) {
                    $q->where('type', 'file')->orWhere('type', 'text');
                })
                ->exists();

            if ($alreadyExists) {
                throw new \Exception("A file named '{$newFileNameWithExt}' already exists in this directory.");
            }

            // Rename file on disk
            if (!File::move($filePath, $newFilePath)) {
                throw new \Exception('Failed to rename file on disk.');
            }

            // Update DB
            $model->name = $newFileNameWithExt;
            $model->save();
        } elseif ($model->type === 'folder') {
            $oldPathRelative = rtrim($model->path, '/');
            $parentPath = dirname($oldPathRelative);
            $newPathRelative = rtrim($parentPath, '/') . '/' . $newName . '/';

            $oldFullPathOnDisk = public_path($oldPathRelative);
            $newFullPathOnDisk = public_path($newPathRelative);
            if (File::exists($newFullPathOnDisk) || FileManager::where('name', $newName)->where('path', $parentPath . '/')->where('type', 'folder')->exists()) {
                throw new \Exception("A folder named '{$newName}' already exists in this directory.");
            }

            if (!File::move($oldFullPathOnDisk, $newFullPathOnDisk)) {
                throw new \Exception('Failed to rename folder on disk.');
            }

            $oldRelativePathInDb = rtrim($model->path, '/') . '/';
            $newRelativePathInDb = $newPathRelative;

            $model->name = $newName;
            $model->path = $newRelativePathInDb;
            $model->save();

            FileManager::where('path', 'like', $oldRelativePathInDb . '%')->get()->each(function ($child) use ($oldRelativePathInDb, $newRelativePathInDb) {
                $child->path = str_replace($oldRelativePathInDb, $newRelativePathInDb, $child->path);
                $child->save();
            });
        } else {
            throw new \Exception('Invalid item type for renaming.');
        }

        return $model;
    }
}

if (!function_exists('deleteItem')) {
    function deleteItem($itemId)
    {
        $model = FileManager::find($itemId);

        if (!$model) {
            Log::error("Item not found for ID: {$itemId}");
            throw new \Exception('Item not found.');
        }

        if ($model->type === 'file') {
            // Delete file from disk
            $fullDiskPath = public_path(trim($model->path, '/') . '/' . $model->name);
            Log::info("Deleting file: " . $fullDiskPath);

            if (file_exists($fullDiskPath)) {
                if (!@unlink($fullDiskPath)) {
                    Log::error("❌ Failed to delete file from disk: " . $fullDiskPath);
                    throw new \Exception("Failed to delete file from disk: {$model->name}");
                }
            } else {
                Log::warning("⚠️ File not found on disk: " . $fullDiskPath);
            }
        } elseif ($model->type === 'folder') {
            // Get full folder path on disk
            $relativeFolderPath = rtrim($model->path);
            $fullDiskPath = public_path($relativeFolderPath);
            Log::info("🧹 Deleting folder from disk: " . $fullDiskPath);

            // Delete folder from disk
            if (is_dir($fullDiskPath)) {
                try {
                    $iterator = new RecursiveDirectoryIterator($fullDiskPath, RecursiveDirectoryIterator::SKIP_DOTS);
                    $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST);
                    foreach ($files as $file) {
                        if ($file->isDir()) {
                            rmdir($file->getRealPath());
                        } else {
                            unlink($file->getRealPath());
                        }
                    }
                    rmdir($fullDiskPath);
                } catch (\Exception $e) {
                    Log::error("❌ Failed to delete folder recursively: " . $e->getMessage());
                    throw new \Exception("Failed to delete folder from disk: {$model->name}");
                }
            } else {
                Log::warning("⚠️ Folder not found or not a directory: " . $fullDiskPath);
            }

            // Delete all children in DB (files/folders)
            $folderDBPath = rtrim($model->path, '/') . '/' . $model->name . '/';
            Log::info("🧹 Deleting child DB records under path: " . $folderDBPath);

            $children = FileManager::where('path', 'like', $relativeFolderPath . '%')->get();

            if ($children->isEmpty()) {
                Log::warning("No child records matched path: " . $relativeFolderPath);
            } else {
                $children->each(function ($child) {
                    $child->delete(); // fires model events, respects soft deletes
                });
            }
            FileManager::where('path', 'like', $folderDBPath . '%')->delete();
        } else {
            Log::error("❌ Invalid item type: " . $model->type);
            throw new \Exception('Invalid item type for deletion.');
        }

        // Delete the current item itself
        if (!$model->delete()) {
            Log::error("❌ Failed to delete DB record for item ID: {$itemId}");
            throw new \Exception('Failed to delete item record from database.');
        }

        Log::info("✅ Item deleted successfully: ID {$itemId}");
        return true;
    }
}
