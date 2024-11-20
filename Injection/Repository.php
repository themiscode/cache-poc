<?php

declare(strict_types=1);

namespace Injection;

/**
 * The simplest possible implementation of cache inside the repository.
 * Setting the cache with DI and getting/setting inside the method.
 */
final class Repository implements RepositoryInterface
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function findById(int $id)
    {
        // Some code before

        $data = $this->cache->get(new CacheKey("some_key_{$id}"));

        if ($data) {
            return $data;
        }

        // Some code after
        $data = 'data from db';

        $this->cache->set(new CacheKey("some_key_{$id}"), $data, 3600);

        return $data;
    }
}