<?php

declare(strict_types=1);

namespace Callback;

/**
 * The simplest possible implementation of cache inside the repository.
 * Setting the cache with DI and getting/setting inside the method.
 */
final class Repository implements RepositoryInterface
{
    use CacheTrait;

    private Cache $cache;
    private $db;

    public function __construct(Cache $cache, $db)
    {
        $this->cache = $cache;
        $this->db = $db;
    }

    public function findById(int $id)
    {
        // Some code before

        return $this->tryFromCache(
            fn() => $this->db->getById($id),
            new CacheKey($id),
            3600
        );
    }
}