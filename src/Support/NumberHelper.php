<?php

namespace Esolutions\Laravel\Support;

class NumberHelper
{
    public static function format(float|int|string $value, int $decimals = 2): string
    {
        return number_format((float) $value, $decimals, '.', '');
    }
}
