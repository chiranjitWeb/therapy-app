<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;

// Guest / Auth Routes
Route::middleware('guest:web')->prefix('auth')->group(static function () {

    Route::controller(LoginController::class)->group(static function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login')->name('login.attempt');
    });

    Route::controller(ForgotPasswordController::class)->group(static function () {
        Route::get('forgot-password', 'show')->name('password.request');
        Route::post('forgot-password', 'send')->name('password.email');
    });

    Route::controller(ResetPasswordController::class)->group(static function () {
        Route::get('reset-password/{token}', 'show')->name('password.reset');
        Route::post('reset-password', 'reset')->name('password.update');
    });
});

// Authenticated Routes
Route::middleware(['auth'])->group(static function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'redirectToDashboard'])->name('home');

    Route::controller(DashboardController::class)->group(static function () {
        Route::get('dashboard', 'index')->name('dashboard')->middleware('role:admin|therapist|user');
    });

    Route::controller(CalendarController::class)->group(static function () {
        Route::get('calendar', 'board')->name('calendar')->middleware('role:therapist');
    });
});
