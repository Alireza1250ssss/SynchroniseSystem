<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($message = null, $data = [], $statusCode = ResponseAlias::HTTP_OK) {
            $message ??= __('messages.success');
            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });

        Response::macro('error', function ($message, $data = [], $statusCode = ResponseAlias::HTTP_BAD_REQUEST) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });

        Response::macro('serverError', function ($message, $statusCode = ResponseAlias::HTTP_BAD_REQUEST) {
            return response()->json([
                'status' => false,
                'message' => $message,
            ], $statusCode);
        });

        Response::macro('forbidden', function ($message = null, $data = [], $statusCode = ResponseAlias::HTTP_FORBIDDEN) {
            $message ??= __('auth.authorize_error');
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => $data
            ], $statusCode);
        });

        Response::macro('notFound', function ($message = null, $statusCode = ResponseAlias::HTTP_NOT_FOUND) {
            $message ??= __('messages.notFound');
            return response()->json([
                'status' => false,
                'message' => $message,
            ], $statusCode);
        });

        Response::macro('validationError', function ($message, $errors = []) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'data' => [
                    'errors' => $errors
                ]
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        });
    }
}
