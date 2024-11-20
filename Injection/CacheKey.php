<?php

declare(strict_types=1);

namespace Injection;

final class CacheKey
{
    private string $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function toString(): string
    {
        return $this->key;
    }
}