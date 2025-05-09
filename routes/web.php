<?php

use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Role\RoleController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('index');
});

Route::prefix('/')->middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('index');

    Route::prefix('permission/')->name('permission.')->controller(PermissionController::class)->group(function () {
        Route::get('', 'index')->name('index')->can('permission.index');

        Route::prefix('{permission}/')->group(function () {
            Route::get('edit', 'edit')->name('edit')->can('permission.update', 'permission');
            Route::put('', 'update')->name('update')->middleware(HandlePrecognitiveRequests::class)->can('permission.update', 'permission');
        });
    });

    Route::prefix('roles/')->name('roles.')->controller(RoleController::class)->group(function () {
        Route::get('', 'index')->name('index')->can('roles.index');
        Route::get('/create', 'create')->name('create')->can('roles.store');
        Route::post('/', 'store')->name('store')->can('roles.store');

        Route::prefix('{role}/')->group(function () {
            Route::get('', 'show')->name('show')->can('roles.show', 'role_user');
            Route::get('edit', 'edit')->name('edit')->can('roles.update', 'role_user');
            Route::put('', 'update')->name('update')->can('roles.update', 'role_user');
            Route::delete('', 'destroy')->name('destroy')->can('roles.destroy', 'role_user');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
