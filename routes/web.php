<?php

use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::resource('permissions', PermissionController::class);

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
