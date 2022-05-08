<?php
namespace App\Categories\Application\Query\FindRoots;

use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(private readonly CategoryRepositoryInterface $repository)
    {}
    
    public function __invoke(Query $query): array
    {
        return $this->repository->findRoots($query->active);
    }
}