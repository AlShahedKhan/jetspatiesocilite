<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\DashboardController;
use Laravel\Jetstream\Rules\Role;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('auth.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('auth.callback');
});


Route::get('/php-version', function () {
    return 'PHP Version: ' . phpversion();
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Route::resource('permissions', PermissionController::class);
    Route::controller(PermissionController::class)->prefix('permissions')->group(function () {
        Route::get('/', 'index')->name('permissions.index')->middleware('PermissionCheck:permission_read');
        Route::get('/create', 'create')->name('permissions.create')->middleware('PermissionCheck:permission_create');
        Route::post('/', 'store')->name('permissions.store')->middleware('PermissionCheck:permission_create');
        Route::get('/{permission}/edit', 'edit')->name('permissions.edit')->middleware('PermissionCheck:permission_update');
        Route::put('/{permission}', 'update')->name('permissions.update')->middleware('PermissionCheck:permission_update');
        Route::delete('/{permission}', 'destroy')->name('permissions.destroy')->middleware('PermissionCheck:permission_delete');
    });
    // Route::resource('roles', RoleController::class);
    // Route::resource('roles', RoleController::class)->middleware('PermissionCheck:role delete');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index')->middleware('PermissionCheck:role_read');
        Route::get('/create', 'create')->name('roles.create')->middleware('PermissionCheck:role_create');
        Route::post('/', 'store')->name('roles.store')->middleware('PermissionCheck:role_create');
        Route::get('/{role}/edit', 'edit')->name('roles.edit')->middleware('PermissionCheck:role_update');
        Route::put('/{role}', 'update')->name('roles.update')->middleware('PermissionCheck:role_update');
        Route::delete('/{role}', 'destroy')->name('roles.destroy')->middleware('PermissionCheck:role_delete');
        Route::get('/{role}/give-permissions', 'addPermissionToRole')->name('roles.add-permissions')->middleware('PermissionCheck:add_role_permissions');
        Route::put('/{role}/give-permissions', 'givePermissionToRole')->name('roles.give-permissions')->middleware('PermissionCheck:give_role_permissions');
    });

    // Route::get('/roles/{role}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.add-permissions');
    // Route::put('/roles/{role}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permissions');

    // Route::resource('users', UserController::class);
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->name('users.index')->middleware('PermissionCheck:user_read');
        Route::get('/create', 'create')->name('users.create')->middleware('PermissionCheck:user_create');
        Route::post('/', 'store')->name('users.store')->middleware('PermissionCheck:user_create');
        Route::get('/{user}/edit', 'edit')->name('users.edit')->middleware('PermissionCheck:user_update');
        Route::put('/{user}', 'update')->name('users.update')->middleware('PermissionCheck:user_update');
        Route::delete('/{user}', 'destroy')->name('users.destroy')->middleware('PermissionCheck:user_delete');
    });

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
