<?php
namespace App\Context\Category\Application\Query\Get;

use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;

class Handler
{
    public function __construct(
        private CategoryRepositoryInterface $_repository
    )
    {}

    public function handle(Query $query): Category
    {
        return $this->_repository->get($query->getId());
    }
}