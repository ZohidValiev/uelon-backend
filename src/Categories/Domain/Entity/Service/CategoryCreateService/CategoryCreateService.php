<?php
namespace App\Categories\Domain\Entity\Service\CategoryCreateService;

use App\Categories\Domain\Entity\Category;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;

class CategoryCreateService
{
    public function __construct(private CategoryRepositoryInterface $_repository)
    {}

    public function __invoke(ServiceParam $param)
    {
        $category = new Category();
        $category
            ->setIcon($param->icon)
            ->setIsActive($param->isActive)
            ->setPosition($this->_repository->getNextPosition($param->parentId))
        ;

        // It sets parent category if it exists
        if ($param->parentId === null) {
            $category->addRelation($category);
        } else {
            $parentCategory = $this->_repository->getById($param->parentId);
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

        /**
         * @var array $translation
         */
        foreach ($param->translations as $translation)
        {
            $category->addTranslation(
                locale: $translation['locale'],
                title: $translation['title'],
            );
        }

        $this->_repository->save($category);

        return $category;
    }
}