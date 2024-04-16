<?php

use App\Http\Controllers\Manage\CategoryController;
use App\Http\Controllers\Manage\ProductCategoryController;
use App\Http\Controllers\Manage\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::prefix('manage')
    ->middleware('auth')
    ->group(function () {
        Route::prefix('/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])
                ->name('manage.categories.index');

            Route::post('/', [CategoryController::class, 'store'])
                ->can('create', Category::class)
                ->name('manage.categories.store');

            Route::get('/create', [CategoryController::class, 'create'])
                ->can('create', Category::class)
                ->name('manage.categories.create');

            Route::prefix('/{category}')->group(function () {
                Route::get('/', [CategoryController::class, 'edit'])
                    ->can('update', 'category')
                    ->name('manage.categories.edit');

                Route::patch('/', [CategoryController::class, 'update'])
                    ->can('update', 'category')
                    ->name('manage.categories.update');

                Route::delete('/', [CategoryController::class, 'destroy'])
                    ->can('delete', 'category')
                    ->name('manage.categories.destroy');
            });
        });

        Route::prefix('/products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])
                ->name('manage.products.index');

            Route::post('/', [ProductController::class, 'store'])
                ->can('create', Product::class)
                ->name('manage.products.store');

            Route::get('/create', [ProductController::class, 'create'])
                ->can('create', Product::class)
                ->name('manage.products.create');

            Route::prefix('/{product}')->group(function () {
                Route::get('/', [ProductController::class, 'edit'])
                    ->can('update', 'product')
                    ->name('manage.products.edit');

                Route::patch('/', [ProductController::class, 'update'])
                    ->can('update', 'product')
                    ->name('manage.products.update');

                Route::delete('/', [ProductController::class, 'destroy'])
                    ->can('delete', 'product')
                    ->name('manage.products.destroy');

                Route::prefix('categories')->group(function () {
                    Route::get('/', [ProductCategoryController::class, 'index'])
                        ->can('view', 'product')
                        ->name('manage.products.categories.index');

                    Route::post('/', [ProductCategoryController::class, 'store'])
                        ->can('update', 'product')
                        ->name('manage.products.categories.store');

                    Route::put('/', [ProductCategoryController::class, 'update'])
                        ->can('update', 'product')
                        ->name('manage.products.categories.update');

                    Route::delete('/', [ProductCategoryController::class, 'destroy'])
                        ->can('update', 'product')
                        ->name('manage.products.categories.destroy');
                });
            });
        });
    });
