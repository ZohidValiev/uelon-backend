<?php
namespace App\Categories\Domain\Entity\Service;

use App\Categories\Domain\Entity\Category;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;

class CategoryDeleteService
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(Category $category): void
    {
        if ($category->getHasChildren()) {
            throw new \DomainException("Category by id = {$category->getId()} has children categories.");
        }

        $parentCategory = $category->getParent();
        
        if ($parentCategory == null) {
            $this->_repository->remove($category);
            $sublings = $this->_repository->findByParentIdAndGreaterThanPosition(
                    null, 
                    $category->getPosition()
                );
        } else {
            $parentCategory->removeChild($category);
            $sublings = \array_filter(
                $parentCategory->getChildren(), 
                function (Category $child) use ($category) {
                    return $child->getPosition() > $category->getPosition();
                }
            );
        }

        foreach ($sublings as $subling) {
            $subling->positionUp();
        }
    }
}