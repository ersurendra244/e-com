<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withInput()->with('error', 'Invalid email or password.');
        }

        $user = Auth::user();

        if ($user && !$user->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Please verify your email address before logging in. Check your email for the verification link.');
        }

        // Dynamic redirect — koi bhi role ho, ek hi code kaam karega
        $role = slug(auth()->user()->roles()->first()->name);

        if (!$role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No role assigned. Contact admin.');
        }

        return redirect("/{$role}/dashboard")->with('success', 'Logged in Successfully.');
    }
    public function verifyEmail($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Invalid verification link.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')
                ->with('success', 'Email already verified. Please login.');
        }

        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        // Dynamic redirect — role se URL build hota hai
        $role = slug(auth()->user()->roles()->first()->name);

        if (!$role) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No role assigned. Contact admin.');
        }

        return redirect("/{$role}/dashboard")->with('success', 'Email verified successfully.');
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

        // Dynamic redirect — koi bhi role ho, ek hi code kaam karega
        $roleName = slug(auth()->user()->roles()->first()->name);

        if (!$roleName) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No role assigned. Contact admin.');
        }

        return redirect("/{$roleName}/dashboard")
            ->with('success', 'Welcome! Signed up as ' . ucfirst($roleName) . '.');
    }
}
