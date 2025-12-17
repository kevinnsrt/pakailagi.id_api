<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PromotionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/tambah-barang', [ProductsController::class, 'tambah_barang'])->name('tambah-barang');
    Route::get('/history', [CartController::class, 'historyAdmin'])->name('history.admin');
    Route::post('/proses/pesanan/{id}', [CartController::class, 'prosesPesanan'])->name('proses.pesanan');
    Route::post('/batal/pesanan/{id}', [CartController::class, 'batalPesanan'])->name('batal.pesanan');
    Route::post('/tambah-barang', [ProductsController::class, 'store'])->name('tambah-barang-post');
    Route::get('/barang', [ProductsController::class, 'show'])->name('barang'); 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/barang/{id}', [ProductsController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [ProductsController::class, 'destroy'])->name('barang.destroy');

    Route::get('/promosi', [PromotionController::class, 'index'])->name('promosi.index');
    Route::post('/promosi', [PromotionController::class, 'store'])->name('promosi.store');
    Route::delete('/promosi/{id}', [PromotionController::class, 'destroy'])->name('promosi.destroy');

});

require __DIR__.'/auth.php';
