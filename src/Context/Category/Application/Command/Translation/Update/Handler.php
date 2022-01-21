<?php
namespace App\Context\Category\Application\Command\Translation\Update;

use App\Context\Category\Domain\Entity\CategoryTranslation;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private Manager $_em,
    )
    {}

    /**
     * @throws NotFoundDomainException
     */
    public function handle(Command $command): ?CategoryTranslation
    {       
        try {
            $category = $this->repository->getByIdWithTranslations($command->categoryId);

            $translation = $category->updateTranslation($command->locale, $command->title);
            
            $this->_em->flush();

            return $translation;
        } catch (NotFoundDomainException $e) {
            throw new NotFoundDomainException('Category translation entity has not been found.', 0, $e);
        }
    }
}