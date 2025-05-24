<?php

use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function() {
            return response()->json([
                'success' => true,
                'message' => 'Welcome to the API',
                'data' => null,
                'statusCode' => 200,
                'code' => 'OK'
            ]);
        })->name('api.welcome');
    });
}

