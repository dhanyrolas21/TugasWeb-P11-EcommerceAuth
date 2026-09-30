<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::where('is_active', true)->latest()->get();
    return view('welcome', compact('products'));
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Utama Multi-Role
    Route::get('/dashboard', function () {
        $products = Product::where('is_active', true)->latest()->get();
        return view('dashboard', compact('products'));
    })->middleware('verified')->name('dashboard');

    // --- ROUTE FUNGSI CRUD PRODUK ---
    
    // Admin Only: Tambah & Hapus
    Route::middleware('role:admin')->group(function () {
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // Admin & Editor: Update/Edit
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
});