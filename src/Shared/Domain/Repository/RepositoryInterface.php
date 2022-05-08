<?php
namespace App\Shared\Domain\Repository;


interface RepositoryInterface
{
    public function save(object $entity, bool $flush = false);

    public function persist(object $entity): void;

    public function remove(object $entity): void;

    public function flush(): void;

    public function wrapInTransaction(callable $func): mixed;
}