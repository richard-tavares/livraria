<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ($request->expectsJson()) {
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'title' => $e instanceof NotFoundException ? 'Recurso não encontrado' : 'Erro',
                    'message' => $e->getMessage(),
                ], $e->getStatusCode());
            }

            return response()->json([
                'title' => 'Erro interno',
                'message' => 'Ocorreu um erro inesperado.',
            ], 500);
        }

        return parent::render($request, $e);
    }
}
