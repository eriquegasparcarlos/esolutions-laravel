<?php

namespace Esolutions\Laravel\Cache;

class HelperCache
{
    public static function nameCache(string $name, string $type = 'table'): string
    {
        return "k_{$type}_{$name}";
    }
}
