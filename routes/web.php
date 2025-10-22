<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReguController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class) // <-- Panggil Controller
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/settings', [SettingsController::class, 'index'])
    ->middleware(['auth'])
    ->name('settings');

Route::view('profile', 'profile') // <-- PASTIKAN BARIS INI ADA
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    // Ini akan otomatis membuat route untuk:
    // index, create, store, show, edit, update, destroy
    Route::resource('users', UserController::class);

    // Route custom untuk ganti status aktif/non-aktif
    Route::patch('users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::post('/users/check-username', [UserController::class, 'checkUsername'])->name('users.checkUsername');
    Route::post('/users/check-email', [UserController::class, 'checkEmail'])->name('users.checkEmail');

    Route::resource('regu', ReguController::class);

});

require __DIR__ . '/auth.php';
