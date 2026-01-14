<?php

use App\Facades\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'active' => \App\Http\Middleware\ActiveUserMiddleware::class,
            'CheckSubscription' => \App\Http\Middleware\CheckSubscription::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::unauthrized();
            }
        });

        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::notFound();
            }
        });

        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::notFound();
            }
        });

        $exceptions->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                $errors = $e->errors();

                $formattedErrors = [];

                foreach ($errors as $field => $message) {
                    $formattedErrors[$field] = $message[0];
                }
                return ApiResponse::validationError($formattedErrors);
            }
        });

        $exceptions->renderable(function (\Exception $e, $request) {
            if ($request->expectsJson()) {
                return ApiResponse::serverError($e->getMessage());
            }
        });
    })->create();
