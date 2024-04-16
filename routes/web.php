<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [StoreController::class, 'index'])
    ->name('stores.index');

Route::prefix('/stores/{storeId}')->group(function () {
    Route::get('/', [StoreController::class, 'products'])
        ->name('stores.show');

    Route::get('/{category:slug}', [StoreController::class, 'category'])
        ->name('stores.show.category');
});

Route::prefix('/cart/{storeId}')->group(function () {
    Route::get('/', [OrderProductController::class, 'index'])
        ->name('stores.cart.index');

    Route::get('/checkout', [OrderController::class, 'checkout'])
        ->name('stores.cart.checkout');

    Route::post('/checkout', [OrderController::class, 'pay'])
        ->name('stores.cart.pay');

    Route::get('/thanks/{order}', [OrderController::class, 'thanks'])
        ->can('view', 'order')
        ->name('stores.cart.thanks');
});

Route::prefix('/order/products')->group(function () {
    Route::post('/', [OrderProductController::class, 'store'])
        ->name('orders.products.store');

    Route::patch('/{orderProduct}', [OrderProductController::class, 'update'])
        ->can('update', 'orderProduct')
        ->name('orders.products.update');

    Route::delete('/{orderProduct}', [OrderProductController::class, 'destroy'])
        ->can('delete', 'orderProduct')
        ->name('orders.products.destroy');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });
});

require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/manage.php';

if (is_file(__DIR__ . '/test.php')) {
    require __DIR__ . '/test.php';
}
