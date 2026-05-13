<?php

namespace Esolutions\Laravel\Logging;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogHelper
{
    public static function logUserException(\Throwable $e, ?Request $request = null): void
    {
        $request = $request ?: request();
        $user    = auth()->user();
        $userId  = $user?->id ?? 'guest';

        $xff          = $request->header('X-Forwarded-For');
        $forwardedIps = $xff ? array_map('trim', explode(',', $xff)) : [];
        $realIp       = $request->header('CF-Connecting-IP')
            ?? $request->header('X-Real-IP')
            ?? ($forwardedIps[0] ?? $request->ip());

        $entry = [
            'timestamp'  => now()->toDateTimeString(),
            'message'    => $e->getMessage(),
            'file'       => $e->getFile(),
            'line'       => $e->getLine(),
            'url'        => $request->fullUrl(),
            'method'     => $request->method(),
            'input'      => $request->all(),
            'user_id'    => $userId,
            'user_email' => $user?->email,
            'ip'         => $realIp,
            'ip_chain'   => $forwardedIps,
            'user_agent' => $request->userAgent(),
            'host'       => $request->getHost(),
            'origin'     => $request->header('Origin'),
            'referer'    => $request->header('Referer'),
        ];

        $filename = storage_path("logs/user-{$userId}.log");
        File::ensureDirectoryExists(dirname($filename));
        file_put_contents($filename, json_encode($entry) . PHP_EOL, FILE_APPEND);
    }
}
