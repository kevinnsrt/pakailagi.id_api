<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';
