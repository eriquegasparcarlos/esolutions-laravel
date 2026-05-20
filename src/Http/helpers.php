<?php

use Esolutions\Laravel\Http\ApiResponse;
use Illuminate\Http\JsonResponse;

if (!function_exists('funcStrToUpper')) {
    function funcStrToUpper($text): string
    {
        return mb_strtoupper($text, 'utf-8');
    }
}

if (!function_exists('funcStrToLower')) {
    function funcStrToLower($text): string
    {
        return mb_strtolower($text, 'utf-8');
    }
}

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

if (!function_exists('funcNumberFormatXml')) {
    function funcNumberFormatXml($value, int $decimals = 2): string
    {
        return \Esolutions\Laravel\Support\NumberHelper::formatXml($value, $decimals);
    }
}

if (!function_exists('number_format_value_price_unit_decimal')) {
    function number_format_value_price_unit_decimal($value, int $decimals = 6): string
    {
        return \Esolutions\Laravel\Support\NumberHelper::formatUnitPrice($value, $decimals);
    }
}

if (!function_exists('qr_generate')) {
    function qr_generate(?string $text): string
    {
        if (empty($text)) return '';

        $size  = 200;
        $image = imagecreate($size, $size);
        imagecolorallocate($image, 255, 255, 255);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return base64_encode($png);
    }
}

if (!function_exists('get_url_pdf')) {
    function get_url_pdf(string $table, $record, string $format = 'a4'): ?string
    {
        $root = ($record->soap_type_id === '01') ? 'demo' : 'production';
        $path = $root . '/' . $table . '/pdf_' . $format . '/' . $record->filename . '.pdf';

        if (\Illuminate\Support\Facades\Storage::exists($path)) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }
        return null;
    }
}
