<?php

use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Tenant\Auth\NewPasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordResetLinkController;
use App\Http\Controllers\Tenant\Auth\RegisteredUserController;
use App\Http\Controllers\Tenant\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest.tenant')->group(function () {
    Route::prefix('register')->group(function() {
        Route::get('/', [RegisteredUserController::class, 'create'])->name('register.tenant');
        Route::post('/', [RegisteredUserController::class, 'store']);
    });
    Route::prefix('login')->group(function () {
        Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login.tenant');
        Route::post('/', [AuthenticatedSessionController::class, 'store']);
    });
    Route::prefix('forgot-password')->group(function () {
        Route::get('/', [PasswordResetLinkController::class, 'create'])->name('password.request.tenant');
        Route::post('/', [PasswordResetLinkController::class, 'store'])->name('password.email.tenant');
    });
    Route::prefix('reset-password')->group(function () {
        Route::get('/{token}', [NewPasswordController::class, 'create'])->name('password.reset.tenant');
        Route::post('/', [NewPasswordController::class, 'store'])->name('password.store.tenant');
    });
});

Route::middleware('auth')->group(function () {
    // This group routes for verify email
    Route::prefix('verify-email')->group(function () {
        Route::get('/', EmailVerificationPromptController::class)->name('verification.notice.tenant');
        Route::get('/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify.tenant');
    });

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send.tenant');

    // This group routes for confirm password
    Route::prefix('confirm-password')->group(function () {
        Route::get('/', [ConfirmablePasswordController::class, 'show'])->name('password.confirm.tenant');
        Route::post('/', [ConfirmablePasswordController::class, 'store']);
    });

    Route::put('password', [PasswordController::class, 'update'])->name('password.update.tenant');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout.tenant');
});
