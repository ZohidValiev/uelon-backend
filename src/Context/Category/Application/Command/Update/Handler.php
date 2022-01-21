<?php
namespace App\Context\Category\Application\Command\Update;

use App\Context\Category\Domain\Entity\Category;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private Manager $_em,
    )
    {
        
    }

    /**
     * @throws NotFoundDomainException
     * @return Category
     */
    public function handle(Command $command): Category
    {
        $category = $this->_repository->getByIdWithTranslations($command->id);

        if ($category == null) {
            throw new NotFoundDomainException("Category by id = $command->id has not been found.");
        }

        $category
            ->setIcon($command->icon)
            ->setIsActive($command->isActive);

        foreach ($command->translations as $translation) {
            $category->updateTranslation($translation->locale, $translation->title);
        }

        $this->_em->flush();

        return $category;
    }
}