<?php
namespace App\Context\Category\Application\Command\Delete;

use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Entity\CategoryDeleteService;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private Manager $_em,
        private CategoryRepositoryInterface $_repository
    )
    {}

    public function handle(Category $category)
    {
        $service = new CategoryDeleteService($this->_em, $this->_repository);
        $this->_em->wrapInTransaction(function() use ($service, $category) {
            $service($category);
        });
    }
}