<?php
namespace App\Categories\Domain\Entity\Service;

use App\Categories\Domain\Entity\Category;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use DomainException;
use InvalidArgumentException;

class CategoryChangePositionService
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(Category $category, int $position): Category
    {
        if (is_null($category->getId())) {
            throw new DomainException("The argument `category` must be persisted entity.");
        }

        if ($position < 1) {
            throw new InvalidArgumentException("An argument position must be greater then zero(0).");
        }

        if ($position === $category->getPosition()) {
            throw new DomainException("Category position has not changed.");
        }

        if ($category->getLevel() === 1) {
            $sublingsWithMe = $this->_repository->findRoots();
        } else {
            $sublingsWithMe = $category->getParent()->getChildren();
        }

        if ($position > count($sublingsWithMe)) {
            throw new \DomainException("");
        }

        if ($position < $category->getPosition()) {
            $this->_doPositionUp($category, $position, $sublingsWithMe);
        } else {
            $this->_doPositionDown($category, $position, $sublingsWithMe);
        }

        return $category;
    }   

    private function _doPositionUp(Category $category, int $position, array $sublings): void
    {
        /**
         * @var Category $subling
         */
        $filteredSublings = \array_filter($sublings, function ($subling) use ($category, $position) {
            return $category !== $subling 
                    && $subling->getPosition() >= $position
                    && $subling->getPosition() < $category->getPosition();
        });

        /**
         * @var Category $filteredSubling
         */
        foreach ($filteredSublings as $filteredSubling) {
            $filteredSubling->positionDown();
        }

        $category->setPosition($position);
    }

    private function _doPositionDown(Category $category, int $position, array $sublings): void
    {
        /**
         * @var Category $subling
         */
        $filteredSublings = \array_filter($sublings, function ($subling) use ($category, $position) {
            return $category !== $subling 
                    && $subling->getPosition() <= $position
                    && $subling->getPosition() > $category->getPosition();
        });

        /**
         * @var Category $filteredSublings
         */
        foreach ($filteredSublings as $filteredSubling) {
            $filteredSubling->positionUp();
        }

        $category->setPosition($position);
    }
}