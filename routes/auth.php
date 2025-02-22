<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Database\ProblemController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::delete('/problems/{id}', [ProblemController::class, 'destroy'])
        ->name('problems.destroy');
    Route::get('/problems/{id}', [ProblemController::class, 'show'])
        ->name('problems.show');
    Route::patch('/problems/{id}/editor', [ProblemController::class, 'updateEditor'])
        ->name('problems.updateEditor');
    Route::patch('/problems/{id}/priority', [ProblemController::class, 'updatePriority'])
        ->name('problems.updatePriority');
    Route::patch('/problems/{id}/status', [ProblemController::class, 'updateStatus'])
        ->name('problems.updateStatus');

        // Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsAdmin::class])->group(function () {
        //     Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        //     Route::post('register', [RegisteredUserController::class, 'store']);
        //     Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        //     Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        // });
        // Route::middleware('admin')->group(function () {
            // Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
            Route::get('/dash/register', [RegisteredUserController::class, 'create'])->name('register');
            Route::post('register', [RegisteredUserController::class, 'store']);
            // Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
            // Route::post('/register', [RegisteredUserController::class, 'store']);
            Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
            Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        // });

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');

        Route::get('verify-email', EmailVerificationPromptController::class)
            ->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')
            ->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });