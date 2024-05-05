<?php

use App\Http\Controllers\ReviewableController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReviewableController::class, 'random'])->name('reviewables.random');
Route::get('reviewables', [ReviewableController::class, 'index'])->name('reviewables.index');
Route::get('reviewables/{path}', [ReviewableController::class, 'show'])->name('reviewables.show');

Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
