<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReviewableController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewerController;
use Illuminate\Support\Facades\Route;

Route::name('reviewables.')->controller(ReviewableController::class)->group(function() {
    Route::get('/', 'random')->name('random');
    Route::get('/review/{reviewable}', 'review')->name('review')->where('reviewable', '.*');
    Route::get('reviewables', 'index')->name('index');
    Route::get('reviewables/geojson', 'geojson')->name('geojson');
    Route::get('reviewables/{path}', 'show')->name('show')->where('path', '.*');
});

Route::name('reviews.')->controller(ReviewController::class)->group(function() {
    Route::get('reviews', 'index')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('reviews/{review}', 'show')->name('show');
});

Route::post('reviews/{review}/comment', [CommentController::class, 'store'])->name('reviews.comment')->can('comment');

Route::name('reviewers.')->controller(ReviewerController::class)->group(function() {
    Route::get('reviewers', 'index')->name('index');
    Route::get('reviewers/{reviewer}', 'show')->name('show');
});

// TODO: varbūt stati grupējot pēc reviewer_id un reviewu filtri pēc tā. Lai identificētu spamerus utml
