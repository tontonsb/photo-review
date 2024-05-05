<?php

use App\Http\Controllers\ReviewableController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::name('reviewables.')->controller(ReviewableController::class)->group(function() {
    Route::get('/', 'random')->name('random');
    Route::get('reviewables', 'index')->name('index');
    Route::get('reviewables/{path}', 'show')->name('show')->where('path', '.*');
});

Route::name('reviews.')->controller(ReviewController::class)->group(function() {
    Route::get('reviews', 'index')->name('index');
    Route::post('reviews', 'store')->name('store');
});

// TODO: varbūt stati grupējot pēc reviewer_id un reviewu filtri pēc tā. Lai identificētu spamerus utml
