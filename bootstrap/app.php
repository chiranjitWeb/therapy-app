<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            // Special handling for logout
            if ($request->is('logout')) {
                return redirect()
                    ->route('login')
                    ->with('status', 'Your session expired, please log in again.');
            }

            // Handle JSON/AJAX requests
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired, please refresh and try again.'
                ], 419);
            }

            // Fallback: redirect to login
            return redirect()
                ->route('login')
                ->with('status', 'Your session expired, please log in again.');
        });
    })
    ->create();
