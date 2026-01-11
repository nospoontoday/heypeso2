<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Test routes for middleware
Route::get('/test-lender', function () {
    return 'lender only';
})->middleware(['auth', 'check.user.type:lender'])->name('test.lender');

Route::get('/test-borrower', function () {
    return 'borrower only';
})->middleware(['auth', 'check.user.type:borrower'])->name('test.borrower');

require __DIR__.'/settings.php';
