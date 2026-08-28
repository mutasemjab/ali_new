<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Every route under /api/* is a JSON API — always render JSON there, regardless
     * of whether the client sent an Accept: application/json header. Without this,
     * Laravel's default behavior falls back to HTML redirects (e.g. redirect()->route('login'),
     * which doesn't even exist in this app) for validation errors, auth failures, 404s, etc.
     *
     * @return mixed
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            return $this->renderApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    private function renderApiException($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors(),
                'data' => null,
            ], $e->status);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
                'data' => null,
            ], 401);
        }

        if ($e instanceof AuthorizationException) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: 'Forbidden',
                'data' => null,
            ], 403);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'status' => false,
                'message' => 'Not found',
                'data' => null,
            ], 404);
        }

        if ($e instanceof HttpExceptionInterface) {
            $status = $e->getStatusCode();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage() ?: (Response::$statusTexts[$status] ?? 'Error'),
                'data' => null,
            ], $status);
        }

        return response()->json([
            'status' => false,
            'message' => config('app.debug') ? $e->getMessage() : 'Server error',
            'data' => null,
        ], 500);
    }
}
