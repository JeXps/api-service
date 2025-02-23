<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;

Route::get('/test', function () {
    return response()->json(['message' => 'Esta API fue realizada por JUAN DAVID ESPINEL PEÑA']);
});

// Rutas de API para products, categories y users
Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('users', UserController::class);


