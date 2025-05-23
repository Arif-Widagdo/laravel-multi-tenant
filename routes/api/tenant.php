<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
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
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'success' => true,
            'message' => 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id'),
            'data' => [
                'tenant' => tenant()->id
            ],
            'statusCode' => 200,
            'code' => 'OK'
        ])->name('api.welcome.tenant');
    });
});