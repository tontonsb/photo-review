<?php

use App\Http\Controllers\ReviewableController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;

Route::name('reviewables.')->controller(ReviewableController::class)->group(function() {
    Route::get('/', 'random')->name('random');
    Route::get('reviewables', 'index')->name('index');
    Route::get('reviewables/{path}', 'show')->name('show')->where('path', '.*');
});

Route::name('reviews.')->controller(ReviewController::class)->group(function() {
    Route::get('reviews', 'index')->name('index');
    Route::post('/', 'store')->name('store');
});

Route::name('reviewers.')->controller(ReviewerController::class)->group(function() {
    Route::get('reviewers', 'index')->name('index');
    Route::get('reviewers/{reviewer}', 'show')->name('show');
});

// TODO: varbūt stati grupējot pēc reviewer_id un reviewu filtri pēc tā. Lai identificētu spamerus utml
