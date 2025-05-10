<?php

use App\Http\Controllers\Iam\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Iam\RoleController;
use App\Http\Controllers\Iam\UserController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('index');
});

Route::prefix('/')->middleware('auth')->group(function () {
    Route::prefix('api/')->name('api.')->group(function () {
        Route::get('roles/search', [RoleController::class, 'searchRole'])->name('roles.search');
    });

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('index');

    Route::prefix('permission/')->name('permission.')->controller(PermissionController::class)->group(function () {
        Route::get('', 'index')->name('index')->can('permission.index');

        Route::prefix('{permission}/')->group(function () {
            Route::get('edit', 'edit')->name('edit')->can('permission.update', 'permission');
            Route::put('', 'update')->name('update')->middleware(HandlePrecognitiveRequests::class)->can('permission.update', 'permission');
        });
    });

    Route::prefix('profile/')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('', [ProfileController::class, 'update'])->name('update');
    });

    Route::prefix('roles/')->name('roles.')->controller(RoleController::class)->group(function () {
        Route::get('', 'index')->name('index')->can('roles.index');
        Route::get('/create', 'create')->name('create')->can('roles.store');
        Route::post('/', 'store')->name('store')->can('roles.store');

        Route::prefix('{role}/')->group(function () {
            Route::get('', 'show')->name('show')->can('roles.show', 'role');
            Route::get('edit', 'edit')->name('edit')->can('roles.update', 'role');
            Route::put('', 'update')->name('update')->can('roles.update', 'role');
            Route::delete('', 'destroy')->name('destroy')->can('roles.destroy', 'role');
        });
    });

    Route::prefix('users/')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('', 'index')->name('index')->can('users.index');
        Route::get('create', 'create')->name('create')->can('users.store');

        Route::post('', 'store')->name('store')->middleware(HandlePrecognitiveRequests::class)->can('users.store');

        Route::prefix('{user}/')->group(function () {
            Route::get('', 'show')->name('show')->can('users.show', 'user');
            Route::get('edit', 'edit')->name('edit')->can('users.update', 'user');
            Route::put('', 'update')->name('update')->middleware(HandlePrecognitiveRequests::class)->can('users.update', 'user');
            Route::delete('', 'destroy')->name('destroy')->can('users.destroy', 'user');
        });
    });
});

require __DIR__.'/auth.php';
