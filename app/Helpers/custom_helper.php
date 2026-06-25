<?php

use App\Models\Master;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


if (!function_exists('getColumnByName')) {
    function getColumnByName($table, $where, $returnColumn, $default = null)
    {
        return DB::table($table)
            ->where('id', $where)
            ->value($returnColumn) ?? $default;
    }
}

if (!function_exists('getColumnByValue')) {
    function getColumnByValue($table, $searchColumn, $searchValue, $returnColumn, $default = null)
    {
        return DB::table($table)
            ->where($searchColumn, $searchValue)
            ->value($returnColumn) ?? $default;
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

if (! function_exists('is_image')) {
    function is_image($path, $image)
    {
        $fullPath = public_path($path . '/' . $image);
        if ($image && file_exists($fullPath)) {
            return asset($path . '/' . $image);
        }
        return asset('images/no-image-1.png');
    }
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
        return str_replace(' ', '-', strtolower(trim($value)));
    }
}

if (!function_exists('currentRole')) {
    function currentRole(): string
    {
        $routeRole = request()->route('role');

        if ($routeRole) {
            return strtolower($routeRole);
        }

        if (auth()->check()) {
            $role = auth()->user()->roles()->first();

            return $role
                ? slug($role->name) // Super Admin => super-admin
                : 'user';
        }

        return 'user';
    }
}

if (!function_exists('roleRoute')) {
    function roleRoute(string $name, $params = [])
    {
        if (!is_array($params)) {
            $params = ['id' => $params];
        }

        $params = array_merge([
            'role' => currentRole()
        ], $params);

        return route($name, $params);
    }
}
