<?php

declare(strict_types=1);

namespace Decorator\WithCallForward;

use Decorator\Cache;
use Decorator\CacheKey;
use Decorator\RepositoryInterface;

/**
 * Here we can wrap the repository within a caching layer.
 * In case we need the repository without the cache in a different
 * class (e.g. a controller) we can use the repository directly.
 * By using call forwarding we remove the need to manually implement
 * all methods of the RepositoryInterface in this class.
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

    public function __call($method, $args)
    {
        if (!method_exists($this->repository, $method)) {
            throw new \BadMethodCallException("Method {$method} does not exist");
        }

        $key = new CacheKey(
            sprintf(
                'some_key_%s_%s_%s',
                self::class,
                $method,
                md5(serialize($args))
            )
        );

        $data = $this->cache->get($key);

        if ($data) {
            return $data;
        }

        $data = $this->repository->{$method}(...$args);

        $this->cache->set($key, $data, 3600);

        return $data;
    }
}