<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            abort(403, 'User is not authenticated.');
        }

        // Ensure permissions are loaded
        if (!$user->relationLoaded('permissions')) {
            $user->load('permissions');
        }

        // Check if the user has the required permission
        if (!$user->can($permission)) {
            abort(403, 'Permission denied.');
        }

        return $next($request);
    }
}
