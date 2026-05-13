<?php

namespace Esolutions\Laravel\Support;

class SystemHelper
{
    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }

    public static function getDomain(): string
    {
        return parse_url(request()->root(), PHP_URL_HOST) ?: '';
    }
}
