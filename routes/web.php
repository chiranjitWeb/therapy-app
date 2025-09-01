<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Calendar\Board as CalendarBoard;

// Route::get('/test-email', function() {
//     \Mail::raw('This is a test email', function($message) {
//         $message->to('cchiranjit.agnitio@gmail.com') // same or another Gmail
//                 ->subject('Test Email from Laravel')
//                 ->from('agnitiodeveloper@gmail.com', 'My App');
//     });
//     return 'Email sent';
// });
Route::middleware('web')->group(function () {
    
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])
     ->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
     ->name('password.update');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard')->middleware('role:admin|therapist|user');
    Route::get('/calendar', CalendarBoard::class)->name('calendar')->middleware('role:therapist');
});
