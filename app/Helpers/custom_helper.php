<?php

use App\Models\User;
use App\Models\Master;
use App\Models\Product;
use App\Models\FileManager;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

if (!function_exists('createFolder')) {
    function createFolder($folderName, $parentPath = 'uploads/file-manager')
    {
        $relativePath = $parentPath . '/' . $folderName;
        $fullPath = public_path($relativePath);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0777, true);
            chmod($fullPath, 0777);
        }

        return $relativePath . '/';
    }
}
if (!function_exists('deleteFolder')) {
    function deleteFolder($folderPath)
    {
        if (!file_exists($folderPath)) return;
        foreach (scandir($folderPath) as $item) {
            if ($item === '.' || $item === '..') continue;
            $itemPath = $folderPath . DIRECTORY_SEPARATOR . $item;
            if (is_dir($itemPath)) {
                deleteFolder($itemPath);
            } else {
                unlink($itemPath);
            }
        }
        rmdir($folderPath);
    }
}

if (!function_exists('createFile')) {
    function createFile($fileName, $parentPath = 'uploads/file-manager')
    {
        $fullPath = public_path($parentPath . '/' . $fileName);

        if (!file_exists($fullPath)) {
            touch($fullPath); // Create an empty file
            chmod($fullPath, 0666); // Set permissions
        }

        return str_replace(public_path() . '/', '', $fullPath);
    }
}
if (!function_exists('renameFolder')) {
    function renameFolder($oldPathRelative, $newFolderName)
    {
        $oldPath = public_path(rtrim($oldPathRelative, '/'));
        $parentPath = dirname($oldPathRelative); // Relative parent path
        $newPathRelative = rtrim($parentPath, '/') . '/' . $newFolderName . '/';
        $newPath = public_path($newPathRelative);

        if (file_exists($oldPath) && is_dir($oldPath)) {
            rename($oldPath, $newPath);

            // ✅ Update all child paths in DB
            FileManager::where('path', 'like', rtrim($oldPathRelative, '/') . '/%')->get()->each(function ($child) use ($oldPathRelative, $newPathRelative) {
                $child->path = str_replace(rtrim($oldPathRelative, '/') . '/', $newPathRelative, $child->path);
                $child->save();
            });

            return $newPathRelative;
        }

        return false;
    }
}

if (!function_exists('renameImage')) {
    function renameImage($image, $path, $newName)
    {
        if (!$image || !$path || !$newName) {
            return false;
        }

        $oldPath = public_path(trim($path, '/') . '/' . $image);
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $newNameWithExt = pathinfo($newName, PATHINFO_FILENAME) . '.' . $extension;
        $newPath = public_path(trim($path, '/') . '/' . $newNameWithExt);

        if (file_exists($oldPath)) {
            rename($oldPath, $newPath);
            return $newNameWithExt; // Return new filename
        }

        return false;
    }
}

function createThumbnail($name, $imagePath, $folderPath, $width, $height)
{
    $manager = new ImageManager(new Driver());

    if (!file_exists($imagePath)) {
        throw new \Exception('Image path is invalid or file does not exist.');
    }

    // Generate unique filename
    $thumbnailName = 'thumb_' . $name;

    $thumbnailFullPath = public_path($folderPath . '/' . $thumbnailName);
    if (!file_exists(dirname($thumbnailFullPath))) {
        mkdir(dirname($thumbnailFullPath), 0755, true);
    }

    try {
        $image = $manager->read($imagePath);
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image->save($thumbnailFullPath, 85);
    } catch (\Intervention\Image\Exceptions\DecoderException $e) {
        throw new \Exception('Failed to decode image: ' . $e->getMessage());
    }

    return $thumbnailName;
}


if (! function_exists('removeImage')) {
    function removeImage($image, $path)
    {
        if ($image && file_exists(public_path($path . '/' . $image))) {
            unlink(public_path($path . '/' . $image));
        }

        return true;
    }
}

if (!function_exists('generatePID')) {
    function generatePID()
    {
        $PID = Product::latest('id')->value('pid');
        if (!$PID) {
            return 'PID0001';
        }
        $numberPart = preg_replace('/\D/', '', $PID);
        $nextSerial = str_pad((intval($numberPart) + 1), 4, '0', STR_PAD_LEFT);
        return 'PID' . $nextSerial;
    }
}

if (!function_exists('getUserRole')) {
    function getUserRole($userId = null)
    {
        $user = $userId ? User::find($userId) : Auth::user();

        return $user && $user->role ? $user->role->name : 'No Role Assigned';
    }
}

if (!function_exists('getUserID')) {
    function getUserID()
    {
        return Auth::user()->id;
    }
}

if (!function_exists('getUserName')) {
    function getUserName($id)
    {
        $user = User::find($id);
        return $user->name;
    }
}

if (!function_exists('getMasterName')) {
    function getMasterName($id)
    {
        $value = Master::where('id', $id)->first();
        return $value->name ?? '';
    }
}

if (!function_exists('slug')) {
    function slug($value)
    {
        return str_replace(' ', '-', strtolower($value));
    }
}
