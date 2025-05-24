<?php

use App\Http\Controllers\Central\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Central\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Central\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Central\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Central\Auth\NewPasswordController;
use App\Http\Controllers\Central\Auth\PasswordController;
use App\Http\Controllers\Central\Auth\PasswordResetLinkController;
use App\Http\Controllers\Central\Auth\RegisteredUserController;
use App\Http\Controllers\Central\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('login')->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/', [AuthenticatedSessionController::class, 'store']);
    });

    Route::prefix('forgot-password')->group(function () {
        Route::get('/', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/', [PasswordResetLinkController::class, 'store'])->name('password.email');
    });

    Route::prefix('reset-password')->group(function () {
        Route::get('/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/', [NewPasswordController::class, 'store'])->name('password.store');
    });
});

Route::middleware('auth')->group(function () {
    // This group routes for verify email
    Route::prefix('verify-email')->group(function () {
        Route::get('/', EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    });

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    // This group routes for confirm password
    Route::prefix('confirm-password')->group(function () {
        Route::get('/', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/', [ConfirmablePasswordController::class, 'store']);
    });

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
