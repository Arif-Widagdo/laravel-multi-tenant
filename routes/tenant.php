<?php

declare(strict_types=1);

use App\Models\Site;
use Illuminate\Support\Facades\Route;
// use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

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
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::domain('{subdomain}.discuss.test')->group(function () {
        Route::get('/', function ($subdomain) {
            $site = Site::where('subdomain', $subdomain)->firstOrFail();
            $posts = $site->posts()->with('user')->latest()->paginate(15);

            return view('public.sites.home', [
                'site' => $site,
                'posts' => $posts,
            ]);
        })->name('site.home');
    });


    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

    Route::view('sites/manage/{site}', 'sites.manage')
    ->middleware(['auth', 'verified'])
        ->name('sites.manage');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');


    require __DIR__.'/auth.php';
});
