<?php
namespace App\Context\Category\Application\Query\FindChildren;

use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;

class Handler
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {}

    public function handle(Query $query): array
    {
        return $this->repository->findChildren($query->getParentId(), $query->getActive());
    }
}
