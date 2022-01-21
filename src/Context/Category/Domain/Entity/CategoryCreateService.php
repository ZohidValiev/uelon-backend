<?php
namespace App\Context\Category\Domain\Entity;

use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;

class CategoryCreateService
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(string $icon, bool $isActive, array $translations, ?int $parentId)
    {
        $category = new Category();
        $category->setIcon($icon);
        $category->setIsActive($isActive);
        $category->setPosition($this->_repository->getNextPosition($parentId));

        // It sets parent category if it exists
        if ($parentId === null) {
            $category->addRelation($category);
        } else {
            $parentCategory = $this->_repository->get($parentId);
            $category->setParent($parentCategory);
            
            /**
             * @var Category $ancestor
             */
            $ancestors   = $this->_repository->findAncestors($parentCategory->getId());
            $ancestors[] = $category;
            foreach ($ancestors as $ancestor) 
            {
                $category->addRelation($ancestor);
            }
        }

        foreach ($translations as $translation)
        {
            $category->addTranslation(
                locale: $translation['locale'],
                title: $translation['title'],
            );
        }

        return $category;
    }
}