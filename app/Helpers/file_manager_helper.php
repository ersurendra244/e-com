<?php

namespace App\Helpers; // Add a namespace for better organization

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB; // For DB::raw
use App\Models\FileManager; // Ensure your model is imported

if (!function_exists('App\Helpers\createFileManagerFolder')) {
    /**
     * Creates a new folder on disk and saves its record in the database.
     *
     * @param string $folderName The name of the folder to create.
     * @param int|null $parentId The ID of the parent folder, if any.
     * @return FileManager The created FileManager model instance.
     * @throws \Exception If folder name is empty or folder already exists.
     */
    function createFileManagerFolder(string $folderName, ?int $parentId = null): FileManager
    {
        if (empty($folderName)) {
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

        $relativePathWithFolderName = rtrim($basePath, '/') . '/' . $folderName . '/';
        $fullDiskPath = public_path($relativePathWithFolderName);

        // Check if a folder with the same name already exists on disk
        if (File::exists($fullDiskPath) && File::isDirectory($fullDiskPath)) {
            throw new \Exception("A folder named '{$folderName}' already exists on disk in this location.");
        }

        // Check if a folder with the same name already exists in the database for this parent
        $existingFolderInDb = FileManager::where('name', $folderName)
                                        ->where('path', $relativePathWithFolderName)
                                        ->where('type', 'folder')
                                        ->first();
        if ($existingFolderInDb) {
            throw new \Exception("A folder named '{$folderName}' already exists in the database for this location.");
        }

        // Create directory recursively with 0777 permissions
        if (!File::makeDirectory($fullDiskPath, 0777, true, true)) {
            throw new \Exception('Failed to create folder on disk.');
        }

        $model = new FileManager();
        $model->name = $folderName;
        $model->type = 'folder';
        $model->path = $relativePathWithFolderName;
        $model->parent_id = $parentId;
        $model->size = 0; // Folders typically have 0 size
        $model->save();

        return $model;
    }
}

if (!function_exists('App\Helpers\uploadFileManagerFiles')) {
    /**
     * Uploads multiple files to disk and saves their records in the database.
     *
     * @param array $files An array of uploaded file instances (e.g., from $request->file('files')).
     * @param int|null $parentId The ID of the parent folder, if any.
     * @return int The number of files successfully uploaded.
     * @throws \Exception If no files are provided or upload fails.
     */
    function uploadFileManagerFiles(array $files, ?int $parentId = null): int
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
            while (File::exists($fullPathDir . '/' . $uniqueName) ||
                   FileManager::where('name', $uniqueName)
                              ->where('path', $dbPathForFile)
                              ->where('type', 'file')
                              ->exists()) {
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

if (!function_exists('App\Helpers\renameFileManagerItem')) {
    /**
     * Renames a file or folder on disk and updates its record in the database,
     * including child paths for folders.
     *
     * @param int $itemId The ID of the item (file or folder) to rename.
     * @param string $newName The new name for the item.
     * @return FileManager The updated FileManager model instance.
     * @throws \Exception If item not found, name is empty, or renaming fails.
     */
    function renameFileManagerItem(int $itemId, string $newName): FileManager
    {
        if (trim($newName) === '') {
            throw new \Exception('Name cannot be empty.');
        }

        $model = FileManager::find($itemId);

        if (!$model) {
            throw new \Exception('Item not found.');
        }

        if ($model->name === $newName) {
            return $model; // No change needed
        }

        if ($model->type === 'file') {
            $oldFileName = $model->name;
            $extension = pathinfo($oldFileName, PATHINFO_EXTENSION);
            $newFileNameWithExt = pathinfo($newName, PATHINFO_FILENAME) . '.' . $extension;

            $filePath = public_path($model->path . $oldFileName);
            $newFilePath = public_path($model->path . $newFileNameWithExt);

            // Check for existing file on disk and in DB
            if (File::exists($newFilePath) ||
                FileManager::where('name', $newFileNameWithExt)
                           ->where('path', $model->path)
                           ->where('type', 'file')
                           ->exists()) {
                throw new \Exception("A file named '{$newFileNameWithExt}' already exists in this directory.");
            }

            if (!File::move($filePath, $newFilePath)) {
                throw new \Exception('Failed to rename file on disk.');
            }

            $model->name = $newFileNameWithExt;
            $model->save();

        } elseif ($model->type === 'folder') {
            $oldFolderName = $model->name;
            $oldFullPathOnDisk = public_path($model->path . $oldFolderName);
            $newFullPathOnDisk = public_path($model->path . $newName);

            // Check for existing folder on disk and in DB
            if (File::exists($newFullPathOnDisk) ||
                FileManager::where('name', $newName)
                           ->where('path', $model->path) // Check for same parent path
                           ->where('type', 'folder')
                           ->exists()) {
                throw new \Exception("A folder named '{$newName}' already exists in this directory.");
            }

            if (!File::move($oldFullPathOnDisk, $newFullPathOnDisk)) {
                throw new \Exception('Failed to rename folder on disk.');
            }

            // Update database records
            $oldRelativePathInDb = $model->path . $oldFolderName . '/';
            $newRelativePathInDb = $model->path . $newName . '/';

            // Update the current folder's own record
            $model->name = $newName;
            // If the `path` column for folders includes their own name, update it too
            // Based on createFileManagerFolder, it does: `relativePathWithFolderName` includes $folderName
            $model->path = rtrim($model->path, $oldFolderName . '/') . $newName . '/'; // Correctly adjust own path
            $model->save();

            // Update paths for all children (files and subfolders)
            DB::table('file_managers')
                ->where('path', 'like', $oldRelativePathInDb . '%')
                ->update(['path' => DB::raw("REPLACE(path, '{$oldRelativePathInDb}', '{$newRelativePathInDb}')")]);

        } else {
            throw new \Exception('Invalid item type for renaming.');
        }

        return $model;
    }
}

if (!function_exists('App\Helpers\deleteFileManagerItem')) {
    /**
     * Deletes a file or folder from disk and its record(s) from the database.
     *
     * @param int $itemId The ID of the item to delete.
     * @return bool True on success, false on failure.
     * @throws \Exception If item not found or deletion fails.
     */
    function deleteFileManagerItem(int $itemId): bool
    {
        $model = FileManager::find($itemId);

        if (!$model) {
            throw new \Exception('Item not found.');
        }

        $fullDiskPath = '';
        if ($model->type === 'file') {
            $fullDiskPath = public_path($model->path . $model->name);
            if (File::exists($fullDiskPath) && !File::delete($fullDiskPath)) {
                throw new \Exception('Failed to delete file from disk: ' . $model->name);
            }
        } elseif ($model->type === 'folder') {
            $fullDiskPath = public_path($model->path . $model->name);
            if (File::exists($fullDiskPath) && !File::deleteDirectory($fullDiskPath)) {
                throw new \Exception('Failed to delete folder from disk: ' . $model->name);
            }
            // Delete all children records from DB first
            $folderRelativePath = $model->path . $model->name . '/';
            FileManager::where('path', 'like', $folderRelativePath . '%')->delete();
        } else {
            throw new \Exception('Invalid item type for deletion.');
        }

        // Delete the item's own record from the database
        if (!$model->delete()) {
            throw new \Exception('Failed to delete item record from database.');
        }

        return true;
    }
}
