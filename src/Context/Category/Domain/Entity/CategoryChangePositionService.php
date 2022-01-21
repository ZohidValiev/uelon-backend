<?php
namespace App\Context\Category\Domain\Entity;

use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;


class CategoryChangePositionService
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(int $id, int $position): Category
    {
        if ($position < 1) {
            throw new \DomainException("Аргумент position должен быть больше нуля(0).");
        }

        $category = $this->_repository->get($id);

        if ($position === $category->getPosition()) {
            throw new \DomainException("");
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