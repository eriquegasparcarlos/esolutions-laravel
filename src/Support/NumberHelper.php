<?php

namespace Esolutions\Laravel\Support;

class NumberHelper
{
    public static function format(float|int|string $value, int $decimals = 2): string
    {
        return number_format((float) $value, $decimals, '.', '');
    }

    public static function formatXml(float|int|string $value, int $decimals = 2): string
    {
        return number_format((float) $value, $decimals, '.', '');
    }

    public static function formatUnitPrice(float|int|string $value, int $decimals = 6): string
    {
        return number_format((float) $value, $decimals, '.', '');
    }
}
