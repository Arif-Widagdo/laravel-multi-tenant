<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

use App\Http\Controllers\Tenant\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Tenant\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Tenant\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Tenant\Auth\NewPasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordController;
use App\Http\Controllers\Tenant\Auth\PasswordResetLinkController;
use App\Http\Controllers\Tenant\Auth\VerifyEmailController;
use App\Http\Controllers\Tenant\Auth\RegisteredUserController;
use App\Http\Controllers\Tenant\ProfileController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::view('/', 'pages.tenant.welcome')->name('welcome.tenant');

    Route::middleware('auth')->group(function () {
        // This group routes for dashboard
        Route::middleware('verified')->prefix('/dashboard')->group(function () {
            // Route::view('/', 'pages.tenant.dashboard.index')->name('dashboard.tenant');
            Route::get('/', function(){
                return view('pages.tenant.dashboard.index');
            })->name('dashboard.tenant');
        });

        Route::prefix('/profile')->group(function () {
            Route::get('/', [ProfileController::class, 'edit'])->name('dashboard.profile.edit.tenant');
            Route::patch('/', [ProfileController::class, 'update'])->name('dashboard.profile.update.tenant');
            Route::delete('/', [ProfileController::class, 'destroy'])->name('dashboard.profile.destroy.tenant');
        });
    });

    require __DIR__.'/auth.php';
});
