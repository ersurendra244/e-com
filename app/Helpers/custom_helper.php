<?php

use App\Models\User;
use App\Models\Master;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


    if (!function_exists('priceRange')) {
        function priceRange()
        {
            return [
                '1' => '500 - 1000',
                '2' => '1000 - 2000',
                '3' => '2000 - 3000',
                '4' => '3000 - 4000',
                '5' => '4000 - 5000',
                '6' => '6000 - 30000',
            ];
        }
    }

    if (!function_exists('colors')) {
        function colors()
        {
            return [
                'Black'  => 'Black',
                'White'  => 'White',
                'Red'    => 'Red',
                'Blue'   => 'Blue',
                'Green'  => 'Green',
            ];
        }
    }

    if (!function_exists('sizes')) {
        function sizes()
        {
            return [
                'XS'  => 'XS',
                'SM'  => 'SM',
                'MD'  => 'MD',
                'LG'  => 'LG',
                'XL'  => 'XL',
                'XXL' => 'XXL',
            ];
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
            return $value->name??'';
        }
    }
