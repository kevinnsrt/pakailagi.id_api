<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// products
Route::get('/products',[ProductsController::class,'index']);
Route::post('/products',[ProductsController::class,'store']);

// firebase auth
Route::post('/firebase-login', [FirebaseAuthController::class, 'login']);