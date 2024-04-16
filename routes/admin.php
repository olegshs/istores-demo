<?php

use App\Http\Controllers\Admin\CurrentStoreController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')
    ->middleware(['auth', 'can:admin'])
    ->group(function () {
        Route::prefix('/stores')->group(function () {
            Route::put('/current', [CurrentStoreController::class, 'change'])
                ->name('admin.stores.current.change');
        });

        Route::prefix('/users')->group(function () {
            Route::get('/', [UserController::class, 'index'])
                ->name('admin.users.index');

            Route::prefix('/{id}')->group(function () {
                Route::get('/', [UserController::class, 'edit'])
                    ->name('admin.users.edit');

                Route::patch('/', [UserController::class, 'update'])
                    ->name('admin.users.update');

                Route::delete('/', [UserController::class, 'destroy'])
                    ->name('admin.users.destroy');

                Route::prefix('/roles')->group(function () {
                    Route::get('/', [UserRoleController::class, 'index'])
                        ->name('admin.users.roles.index');

                    Route::post('/', [UserRoleController::class, 'store'])
                        ->name('admin.users.roles.store');

                    Route::put('/', [UserRoleController::class, 'update'])
                        ->name('admin.users.roles.update');

                    Route::delete('/', [UserRoleController::class, 'destroy'])
                        ->name('admin.users.roles.destroy');
                });
            });
        });
    });
