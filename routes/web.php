<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewableController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\TutorialController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(LocaleSessionRedirect::class)
    ->group(function() {
        Route::name('reviewables.')->controller(ReviewableController::class)->group(function() {
            Route::get('/', 'random')->name('random');
            Route::get('/review/{reviewable}', 'review')->name('review')->where('reviewable', '.*');
            Route::get('reviewables', 'index')->name('index');
            Route::get('reviewables/geojson', 'geojson')->name('geojson')->middleware('cacheResponse:300');
            Route::get('reviewables/dir', 'dir')->name('directory');
            Route::get('reviewables/{path}', 'show')->name('show')->where('path', '.*');
        });

        Route::name('tutorial.')->controller(TutorialController::class)->group(function() {
            Route::get('tutorial', 'index')->name('index');
            Route::get('tutorial/{reviewable:tutorial_order}', 'show')->name('show');
        });

        Route::name('reviews.')->controller(ReviewController::class)->group(function() {
            Route::get('reviews', 'index')->name('index');
            Route::get('reviews/map', 'map')->name('map');
            Route::post('/', 'store')->name('store');
            Route::get('reviews/{review}', 'show')->name('show');
        });

        Route::post('reviews/{review}/comment', [CommentController::class, 'store'])->name('reviews.comment')->can('comment');

        Route::name('reviewers.')->controller(ReviewerController::class)->group(function() {
            Route::get('reviewers', 'index')->name('index');
            Route::get('reviewers/me', 'me')->name('me');
            Route::get('reviewers/{reviewer}', 'show')->name('show');
        });

        Route::view('map', 'map')->name('map');

        Route::middleware('guest')->group(function() {
            Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
            Route::post('register', [RegisteredUserController::class, 'store']);
            Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
            Route::post('login', [AuthenticatedSessionController::class, 'store']);

            // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
            // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
            // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
            // Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
        });

        Route::middleware('auth')->group(function() {
            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

            Route::get('me', [ProfileController::class, 'me'])->name('me');
            Route::post('bind-reviewer', [ProfileController::class, 'bind'])->name('bind-reviewer');
        });
    });
