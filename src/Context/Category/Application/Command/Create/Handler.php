<?php
namespace App\Context\Category\Application\Command\Create;

use App\Context\Category\Domain\Entity\CategoryCreateService;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private Manager $_em,
    )
    {}
    
    public function handle(Command $command)
    {
        $translations = \array_map(function($translation){
            return [
                'locale' => $translation->getLocale(),
                'title'  => $translation->getTitle(),
            ];
        }, $command->getTranslations());

        $service  = new CategoryCreateService($this->_repository);
        $category = $service(
            $command->getIcon(), 
            $command->getIsActive(), 
            $translations, 
            $command->getParentId()
        );

        $this->_em->persist($category);
        $this->_em->flush();

        return $category;
    }
}