<?php

namespace Esolutions\Laravel\Cache;

use Esolutions\Laravel\Events\CacheTableCleared;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait TraitCache
{
    public static function getNameCache(): string
    {
        $model = static::getModel();
        return HelperCache::nameCache($model->getTable());
    }

    public static function clearCache(): void
    {
        $cacheName = static::getNameCache();
        Cache::forget($cacheName);

        $className = class_basename(static::class);
        $baseName  = preg_replace('/Cache$/', '', $className);
        $tableKey  = Str::plural(lcfirst($baseName));

        $data = static::getCache();

        try {
            event(new CacheTableCleared($tableKey, $data));
        } catch (\Throwable) {
            // silence — listener may not be registered
        }
    }
}
