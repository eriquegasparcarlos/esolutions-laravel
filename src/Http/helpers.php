<?php

use Esolutions\Laravel\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

if (!function_exists('apiSuccess')) {
    function apiSuccess(string $message, int $code = 200, $data = null): JsonResponse
    {
        return ApiResponse::success($message, $code, $data);
    }
}

if (!function_exists('apiError')) {
    function apiError(string $message, int $code = 500, $errors = null): JsonResponse
    {
        return ApiResponse::error($message, $code, $errors);
    }
}

if (!function_exists('apiResponse')) {
    function apiResponse(array $data, int $code = 200): JsonResponse
    {
        return ApiResponse::response($data, $code);
    }
}
