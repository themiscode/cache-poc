<?php

declare(strict_types=1);

namespace Callback;

trait CacheTrait
{
    /**
     * @param callable $callback The function that retrieves the data should they not exist in cache
     * @param CacheKey $key
     * @param int $ttl
     * @return mixed
     */
    public function tryFromCache(callable $dataCallback, CacheKey $key, int $ttl = 3600)
    {
        $data = $this->cache->get($key->toString());

        if ($data) {
            return $data;
        }

        $data = $dataCallback();

        $this->cache->set($key->toString(), $data, $ttl);

        return $data;
    }
}