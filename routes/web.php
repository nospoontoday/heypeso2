<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/time-manipulation', [App\Http\Controllers\TimeManipulationController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin.only'])
    ->name('time.manipulation');

Route::post('/time-manipulation', [App\Http\Controllers\TimeManipulationController::class, 'manipulate'])
    ->middleware(['auth', 'verified', 'admin.only'])
    ->name('time.manipulate');

Route::get('/time-reset', [App\Http\Controllers\TimeManipulationController::class, 'reset'])
    ->middleware(['auth', 'verified', 'admin.only'])
    ->name('time.reset');

// Test routes for middleware
Route::get('/test-lender', function () {
    return 'lender only';
})->middleware(['auth', 'check.user.type:lender'])->name('test.lender');

Route::get('/test-borrower', function () {
    return 'borrower only';
})->middleware(['auth', 'check.user.type:borrower'])->name('test.borrower');

require __DIR__.'/settings.php';
