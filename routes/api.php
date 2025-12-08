<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('firebase.auth')->group(function () {
// products
    Route::get('/products', [ProductsController::class, 'index']);
    Route::post('/products/kategori', [ProductsController::class, 'filter']);
    Route::post('/products/details', [ProductsController::class, 'details']);

// firebase auth
    Route::post('/firebase-register', [FirebaseAuthController::class, 'register']);
    Route::post('/register-google', [FirebaseAuthController::class, 'registerGoogle']);
    
    Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);
    // Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);

// carts
Route::post('/carts/user', [CartController::class, 'show']);
Route::post('/carts/user/proses', [CartController::class, 'showProses']);
Route::post('/carts', [CartController::class, 'store']);
Route::post('/carts/proses', [CartController::class, 'proses']);


// wishlist
    Route::post('/wishlist', [WishlistController::class, 'store']);
    // Route::post('/wishlist/user', [WishlistController::class, 'show']);

    Route::delete('/delete/{id}', [WishlistController::class, 'destroy']);

});

// testing tanpa tokenn



Route::post('/wishlist/user', [WishlistController::class, 'show']);


