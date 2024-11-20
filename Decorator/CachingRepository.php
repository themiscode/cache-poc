<?php

declare(strict_types=1);

namespace Decorator;

/**
 * Here we can wrap the repository within a caching layer.
 * In case we need the repository without the cache in a different
 * class (e.g. a controller) we can use the repository directly.
 */
final class CachingRepository
{
    private RepositoryInterface $repository;

    private Cache $cache;

    public function __construct(RepositoryInterface $repository, Cache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function findById(int $id)
    {
        $key = new CacheKey("some_key_{$id}");

        $data = $this->cache->get($key);

        if ($data) {
            return $data;
        }

        $data = $this->repository->findById($id);

        $this->cache->set($key, $data, 3600);

        return $data;
    }
}