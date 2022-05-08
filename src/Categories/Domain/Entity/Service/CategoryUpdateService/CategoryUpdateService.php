<?php
namespace App\Categories\Domain\Entity\Service\CategoryUpdateService;

use App\Categories\Domain\Entity\Category;
use InvalidArgumentException;

class CategoryUpdateService
{
    public function __invoke(ServiceParam $param)
    {
        $category = $param->category;
        
        if ($category->getId() === null) {
            throw new InvalidArgumentException(
                sprintf("The argument `category` of class %s must be persisted entity.", $category::class)
            );
        }

        $category
            ->setIcon($param->icon)
            ->setIsActive($param->isActive)
        ;

        /**
         * @var array $translation {locale: string, title: string}
         */
        foreach ($param->translations as $translation) {
            $category->updateTranslation(
                $translation['locale'], 
                $translation['title'],
            );
        }
    }
}