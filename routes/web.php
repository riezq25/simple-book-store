<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Riwayat Transaksi
    Route::prefix('order')
        ->name('order.')
        ->controller(OrderController::class)
        ->group(function () {
            Route::get('/', 'index')
                ->name('index');
            Route::get('/create', 'create')
                ->middleware('role:admin')
                ->name('create');
            Route::post('/', 'store')
                ->middleware('role:admin')
                ->name('store');
            Route::get('/{id}', 'show')
                ->name('show');
        });

    Route::middleware('role:admin')->group(function () {
        // Data Master
        // a. Buku
        // menampilkan semua data
        Route::prefix('book')
            ->name('book.')
            ->controller(BookController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->name('index');
                Route::get('/create', 'create')
                    ->name('create');
                Route::post('/', 'store')
                    ->name('store');
                Route::get('/{id}', 'show')
                    ->name('show');
                Route::get('/{id}/edit', 'edit')
                    ->name('edit');
                Route::put('/{id}', 'update')
                    ->name('update');
                Route::delete('/{id}', 'destroy')
                    ->name('destroy');
            });




        // b. Produk
        // c. Supplier


        // Pengguna
        // a. customer
        Route::get('/pengguna/customer', [CustomerController::class, 'index'])
            ->name('customer.index');

        // b. admin
        Route::get('/pengguna/admin', [AdminController::class, 'index'])
            ->name('admin.index');
        Route::get('/pengguna/admin/create', [AdminController::class, 'create'])
            ->name('admin.create');
        Route::post('/pengguna/admin/store', [AdminController::class, 'store'])
            ->name('admin.store');
        Route::get('/pengguna/admin/{id}/edit', [AdminController::class, 'edit'])
            ->name('admin.edit');
        Route::put('/pengguna/admin/{id}/update', [AdminController::class, 'update'])
            ->name('admin.update');
        Route::delete('/pengguna/admin/{id}', [AdminController::class, 'destroy'])
            ->name('admin.destroy');
    });

    // admin only
    Route::middleware('role:admin')->group(function () {
        // Data Master
        // a. Buku
        // menampilkan semua data
        Route::prefix('book')
            ->name('book.')
            ->controller(BookController::class)
            ->group(function () {
                Route::get('/', 'index')
                    ->name('index');
                Route::get('/create', 'create')
                    ->name('create');
                Route::post('/', 'store')
                    ->name('store');
                Route::get('/{id}', 'show')
                    ->name('show');
                Route::get('/{id}/edit', 'edit')
                    ->name('edit');
                Route::put('/{id}', 'update')
                    ->name('update');
                Route::delete('/{id}', 'destroy')
                    ->name('destroy');
            });




        // b. Produk
        // c. Supplier


        // Pengguna
        // a. customer
        Route::get('/pengguna/customer', [CustomerController::class, 'index'])
            ->name('customer.index');

        // b. admin
        Route::get('/pengguna/admin', [AdminController::class, 'index'])
            ->name('admin.index');
        Route::get('/pengguna/admin/create', [AdminController::class, 'create'])
            ->name('admin.create');
        Route::post('/pengguna/admin/store', [AdminController::class, 'store'])
            ->name('admin.store');
        Route::get('/pengguna/admin/{id}/edit', [AdminController::class, 'edit'])
            ->name('admin.edit');
        Route::put('/pengguna/admin/{id}/update', [AdminController::class, 'update'])
            ->name('admin.update');
        Route::delete('/pengguna/admin/{id}', [AdminController::class, 'destroy'])
            ->name('admin.destroy');
    });


    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
