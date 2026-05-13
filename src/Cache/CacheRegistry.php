<?php

namespace Esolutions\Laravel\Cache;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CacheRegistry
{
    public static function getTables(): array
    {
        $path  = app_path('Cache');
        $files = File::allFiles($path);
        $data  = [];

        foreach ($files as $file) {
            $relativePath = $file->getRelativePath();
            if (substr_count($relativePath, DIRECTORY_SEPARATOR) > 1) continue;

            $namespace = 'App\\Cache';
            if (!empty($relativePath)) {
                $namespace .= '\\' . str_replace('/', '\\', $relativePath);
            }

            $className = $namespace . '\\' . $file->getFilenameWithoutExtension();

            if (class_exists($className) && method_exists($className, 'getCache')) {
                $baseName = preg_replace('/Cache$/', '', class_basename($className));
                $key      = Str::plural(lcfirst($baseName));
                $data[$key] = $className::getCache();
            }
        }

        return $data;
    }
}
