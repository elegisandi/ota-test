<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobFeedController;

Route::controller(JobFeedController::class)
    ->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/job/{uuid}', 'show')->name('job.show');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
