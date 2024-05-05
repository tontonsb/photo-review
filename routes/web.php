<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PhotoController::class, 'random']);
Route::get('photos', [PhotoController::class, 'index']);
Route::get('photos/{photo}', [PhotoController::class, 'show']);

Route::get('reviews', [ReviewController::class, 'index']);
Route::post('reviews', [ReviewController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});
