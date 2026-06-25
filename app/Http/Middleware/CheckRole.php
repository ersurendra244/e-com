<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * URL me {role} prefix ko user ke actual role se match karta hai.
     * Agar match nahi hua → 403 abort.
     * Agar match hua → permissions share karta hai view ke saath.
     */
    public function handle(Request $request, Closure $next)
    {
        $rolePrefix = $request->route('role'); // URL me aaya role (admin, user, vendor, etc.)

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // User ke paas URL wala role hona chahiye (case-insensitive)
        $hasRole = $user->roles()
            ->get()
            ->contains(function ($role) use ($rolePrefix) {
                return slug($role->name) === strtolower($rolePrefix);
            });

        if (!$hasRole) {
            // Agar user ka koi role hai toh uske dashboard pe redirect karo
            $firstRole = $user->roles()->first();
            if ($firstRole) {
                return redirect('/' . slug($firstRole->name) . '/dashboard')
                    ->with('error', 'You are not authorized for that role panel.');
            }
            abort(403, 'Unauthorized: Role mismatch.');
        }

        // View me permissions share karo
        $permissions = $user->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique();

        View::share('userPermissions', $permissions);
        View::share('currentRole', $rolePrefix); // Blade me currentRole available hoga

        return $next($request);
    }
}
