<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web/central/_index.php',
        api: __DIR__.'/../routes/api/central/_index.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('universal', []);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, \Throwable $exception, Request $request) {
            $isApiRequest = $request->is('api') || $request->is('api/*') || $request->expectsJson() || str_contains($request->header('accept'), 'application/json');

            if ($isApiRequest) {
                if ($exception instanceof TenantCouldNotBeIdentifiedOnDomainException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tenant not found for domain: ' . $request->getHost(),
                        'errors' => ['tenant' => ['Tenant could not be identified.']],
                        'statusCode' => 404,
                        'code' => 'TENANT_NOT_FOUND'
                    ], 404);
                }

                return response()->json([
                    'success' => false,
                    'message' => $exception->getMessage(),
                    'errors' => ['exception' => [get_class($exception)]],
                    'statusCode' => method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500,
                    'code' => $exception->getCode(),
                ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
            }

            if ($exception instanceof TenantCouldNotBeIdentifiedOnDomainException) {
                return response()->view('pages.errors.tenant-not-found', [], 404);
            }

            return $response;
        });

    })->create();
