<?php

use App\Http\Controllers\Central\ProfileController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Central\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Central\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Central\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Central\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Central\Auth\NewPasswordController;
use App\Http\Controllers\Central\Auth\PasswordController;
use App\Http\Controllers\Central\Auth\PasswordResetLinkController;
use App\Http\Controllers\Central\Auth\VerifyEmailController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function(){
            return view('pages.central.welcome');
        })->name('welcome');

        Route::middleware('auth')->group(function () {
            // This group routes for dashboard
            Route::middleware('verified')->prefix('/dashboard')->group(function () {
                Route::get('/', function(){
                    return view('pages.central.dashboard.index');
                })->name('dashboard');

                Route::resource('/tenants', TenantController::class);
            });

            Route::prefix('/profile')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');
                Route::patch('/', [ProfileController::class, 'update'])->name('dashboard.profile.update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('dashboard.profile.destroy');
            });
        });

        require __DIR__.'/auth.php';
    });
}

