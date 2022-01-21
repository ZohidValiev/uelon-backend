<?php
namespace App\Context\Category\Application\Command\Translation\Create;

use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private Manager $_em,
    )
    {
        
    }

    public function handle(Command $command): CategoryTranslation
    {
        $category = $this->_repository->getByIdWithTranslations($command->categoryId);
        
        $translation = $category->addTranslation($command->locale, $command->title);

        $this->_em->flush();

        return $translation;
    }
}