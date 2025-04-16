<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, $role)
    {
        // if (!auth()->check() || !auth()->user()->hasRole($role)) {
        //     abort(403, 'Unauthorized');
        // }
        if (Auth::check()) {
            $permissions = Auth::user()->roles()->with('permissions')->get()
                ->pluck('permissions')->flatten()->pluck('name')->unique();
            View::share('userPermissions', $permissions);
        }

        return $next($request);
    }
}
