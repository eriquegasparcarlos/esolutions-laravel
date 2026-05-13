<?php

namespace Esolutions\Laravel\Events;

class CacheTableCleared
{
    public function __construct(
        public readonly string $table,
        public readonly array  $data,
    ) {}
}
