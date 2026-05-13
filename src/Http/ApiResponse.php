<?php

namespace Esolutions\Laravel\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    const array HEADERS = ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'];
    const int FLAGS = JSON_UNESCAPED_UNICODE;

    public static function success(string $message, int $code = 200, $data = null): JsonResponse
    {
        $response = ['success' => true, 'message' => $message];
        if (!is_null($data)) $response['data'] = $data;
        return self::response($response, $code);
    }

    public static function error(string $message, int $code = 500, $errors = null): JsonResponse
    {
        $response = ['success' => false, 'message' => $message];
        if (!is_null($errors)) $response['errors'] = $errors;
        return self::response($response, $code);
    }

    public static function response(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code, self::HEADERS, self::FLAGS);
    }
}
