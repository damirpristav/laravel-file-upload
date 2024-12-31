<?php

use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/images', [ImageController::class, 'index']);
Route::get('/storage/uploads/{path}', [ImageController::class, 'show']);
Route::post('/upload', [ImageController::class, 'upload']);
Route::delete('/images/{id}', [ImageController::class, 'destroy']);
