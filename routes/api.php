<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FirebaseAuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// products
Route::get('/products',[ProductsController::class,'index']);

// firebase auth
Route::post('/firebase-register', [FirebaseAuthController::class, 'register']);
Route::post('/login', [FirebaseAuthController::class, 'getUserdata']);