<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        $user = Auth::user();

        return $user ? $user->can($permission) : false;
    }
}
