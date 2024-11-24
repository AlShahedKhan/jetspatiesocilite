<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::resource('permissions', PermissionController::class);
    // Route::resource('roles', RoleController::class);
    // Route::resource('roles', RoleController::class)->middleware('PermissionCheck:role delete');

    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index')->middleware('PermissionCheck:role_read');
        Route::get('/create', 'create')->name('roles.create')->middleware('PermissionCheck:role_create');
        Route::post('/', 'store')->name('roles.store')->middleware('PermissionCheck:role_create');
        Route::get('/{role}/edit', 'edit')->name('roles.edit')->middleware('PermissionCheck:role_update');
        Route::put('/{role}', 'update')->name('roles.update')->middleware('PermissionCheck:role_update');
        Route::delete('/{role}', 'destroy')->name('roles.destroy')->middleware('PermissionCheck:role_delete');
    });



    Route::get('/roles/{role}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.add-permissions');
    Route::put('/roles/{role}/give-permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.give-permissions');

    Route::resource('users', UserController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
