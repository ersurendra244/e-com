<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // if (!Auth::user()->hasRole('admin')) {
        //     return abort(403, 'Unauthorized action.');
        // }
        $data['title'] = 'Dashboard';
        $data['toatlUsers'] = User::count();
        $data['totalProducts'] = Product::count();
        return view('admin.dashboard', $data);
    }

    public function author_dashboard()
    {
        return view('admin.author_dashboard');
    }

    public function user_dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['toatlUsers'] = User::count();
        $data['totalProducts'] = Product::count();
        return view('user.dashboard', $data);
    }

    public function getUser(Request $request) {
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
