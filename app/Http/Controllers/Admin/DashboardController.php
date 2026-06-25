<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['toatlUsers'] = User::count();
        $data['totalProducts'] = Product::count();
        return view('admin.dashboard', $data);
    }

    public function getUser(Request $request)
    {
        $role_id = $request->role_id;
        $users = User::whereHas('roles', function ($query) use ($role_id) {
            $query->where('role_id', $role_id);
        })->get();

        $html = '<option value="">--select--</option>';
        foreach ($users as $user) {
            $html .= '<option value="' . $user->id . '">' . $user->name . '</option>';
        }
        return response()->json($html);
    }
}
