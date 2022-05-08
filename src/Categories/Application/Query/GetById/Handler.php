<?php
namespace App\Categories\Application\Query\GetById;

use App\Categories\Domain\Entity\Category;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(private readonly CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(Query $query): Category
    {
        return $this->_repository->getById($query->id);
    }
}