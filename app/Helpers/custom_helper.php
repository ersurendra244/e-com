<?php

use App\Models\User;
use App\Models\Master;
use App\Models\Product;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
