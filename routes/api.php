<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FirebaseAuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Models\User;
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
    // search
    Route::post('/products/search', [ProductsController::class, 'search']);
    
    // firebase auth
    Route::post('/register-google', [FirebaseAuthController::class, 'registerGoogle']);

    Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);
    // Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);

    // carts
    Route::post('/carts/user', [CartController::class, 'show']);
    // Route::post('/carts/user/proses', [CartController::class, 'showProses']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/proses', [CartController::class, 'proses']);
    Route::post('/carts/selesai', [CartController::class, 'selesai']);

    // wishlist
    Route::post('/wishlist', [WishlistController::class, 'store']);
    // Route::post('/wishlist/user', [WishlistController::class, 'show']);
    Route::delete('/delete/{id}', [WishlistController::class, 'destroy']);

    // update profile
    Route::post('/user/profile', [ProfileController::class, 'update']);


    // fcm token
    Route::post('/save-fcm-token', function (Request $request) {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $request->user()->update([
            'fcm_token' => $request->fcm_token,
        ]);
        // dd($request->user(), $request->fcm_token);

        return response()->json(['success' => true]);
    });

    // location
    Route::post('/update/location', [FirebaseAuthController::class, 'updateLocation']);

    // wishlist
    Route::post('/wishlist/user', [WishlistController::class, 'show']);
    Route::post('/wishlist/store', [WishlistController::class, 'store']);

});
Route::post('/firebase-register', [FirebaseAuthController::class, 'register']);
// testing tanpa tokenn



// Route::post('/user/profile', [ProfileController::class, 'update']);
