<?php

namespace Esolutions\Laravel\Support;

class StringHelper
{
    public static function upper(string $text): string
    {
        return mb_strtoupper($text, 'utf-8');
    }

    public static function lower(string $text): string
    {
        return mb_strtolower($text, 'utf-8');
    }

    public static function removeSpaces(string $text): string
    {
        return preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $text);
    }

    public static function removeNewLines(string $text, string $replacement = ' | '): string
    {
        return preg_replace('/[\r\n]+/', $replacement, trim($text));
    }

    public static function random(int $length, string $chars = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ'): string
    {
        $result = '';
        $max    = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $max)];
        }
        return $result;
    }
}
