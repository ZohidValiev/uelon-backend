<?php
namespace App\Categories\Application\Query\FindChildren;

use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(private readonly CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(Query $query): array
    {
        return $this->_repository->findChildren($query->parentId, $query->active);
    }
}
