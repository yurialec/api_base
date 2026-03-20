<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;
use Log;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'success' => false,
            'message' => 'Não autenticado'
        ], 401);
    }

    public function render($request, Throwable $exception)
    {
        Log::error($exception->getMessage(), [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip()
        ]);

        if ($exception instanceof ValidationException) {
            return ApiResponse::error(
                'Erro de validação',
                $exception->errors(),
                422
            );
        }

        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::error(
                'Recurso não encontrado',
                null,
                404
            );
        }

        if ($exception instanceof HttpExceptionInterface) {
            return ApiResponse::error(
                $exception->getMessage() ?: 'Erro HTTP',
                null,
                $exception->getStatusCode()
            );
        }

        return ApiResponse::error(
            'Erro interno no servidor',
            null,
            500
        );
    }
}