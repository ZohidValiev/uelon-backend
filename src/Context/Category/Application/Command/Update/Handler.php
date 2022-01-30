<?php
namespace App\Context\Category\Application\Command\Update;

use App\Context\Category\Application\Command\Create\Translation;
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
    {}

    /**
     * @throws NotFoundDomainException
     * @return Category
     */
    public function handle(Command $command): Category
    {
        $category = $this->_repository->getByIdWithTranslations($command->getId());

        if ($category == null) {
            throw new NotFoundDomainException("Category by id = {$command->getId()} has not been found.");
        }

        $category
            ->setIcon($command->getIcon())
            ->setIsActive($command->getIsActive());

        /**
         * @var Translation $translation
         */
        foreach ($command->getTranslations() as $translation) {
            $category->updateTranslation(
                $translation->getLocale(), 
                $translation->getTitle()
            );
        }

        $this->_em->flush();

        return $category;
    }
}