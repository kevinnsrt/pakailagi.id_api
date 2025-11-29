<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FirebaseAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('firebase.auth')->group(function () {
// products
Route::get('/products',[ProductsController::class,'index']);
Route::post('/products/kategori',[ProductsController::class,'filter']);

// firebase auth
Route::post('/firebase-register', [FirebaseAuthController::class, 'register']);
Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);

// carts
Route::post('/carts', [CartController::class, 'create']);

});

