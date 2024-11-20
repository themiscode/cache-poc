<?php

declare(strict_types=1);

namespace Decorator;

final class Repository implements RepositoryInterface
{
    public function findById(int $id)
    {
        $data = 'data from db';

        return $data;
    }
}