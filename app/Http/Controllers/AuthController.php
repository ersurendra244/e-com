<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        $data['title'] = 'Login';
        return view('admin.login', $data);
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withInput()->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Logged in as Admin.');
        } elseif ($user->hasRole('Author')) {
            return redirect()->route('author.dashboard')->with('success', 'Logged in as Author.');
        } elseif ($user->hasRole('User')) {
            return redirect()->route('user.dashboard')->with('success', 'Logged in as User.');
        }

        Auth::logout();
        return abort(403, 'Unauthorized action.');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function signup(Request $request, $type = null)
    {
        $data['title'] = 'Sign up';
        if ($type == 'user') {
            $data['roles'] = Role::where('name', $type)->first();
        } else {
            $data['roles'] = Role::all();
        }
        // return $data['roles'];
        return view('admin.signup', $data);
    }
    public function signup_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'role' => 'required|exists:roles,id',
            'password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->roles()->sync([$request->role]);

        Auth::login($user); // Log user in directly

        // Redirect
        if ($user->hasRole('Admin')) {
            return redirect()->route('admin.dashboard')->with('success', 'Signed up as Admin.');
        } elseif ($user->hasRole('Author')) {
            return redirect()->route('author.dashboard')->with('success', 'Signed up as Author.');
        } elseif ($user->hasRole('User')) {
            return redirect()->route('user.dashboard')->with('success', 'Signed up as User.');
        }

        return abort(403, 'Unauthorized action.');
    }
}
