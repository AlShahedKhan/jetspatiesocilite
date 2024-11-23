<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('permissions', PermissionController::class);

Route::resource('roles', RoleController::class);
Route::get('/roles/{role}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.add-permissions');
Route::put('/roles/{role}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permissions');

Route::resource('users', UserController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
