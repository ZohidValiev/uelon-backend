<?php
namespace App\Context\Category\Application\Command\ChangePosition;

use App\Context\Category\Domain\Entity\CategoryChangePositionService;
use App\Context\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Doctrine\Manager;

class Handler 
{
    public function __construct(
        private Manager $_em,
        private CategoryRepositoryInterface $_repository,
    )
    {}

    public function handle(Command $command)
    {
        $repository = $this->_repository;

        $category = $this->_em->wrapInTransaction(function() use ($command, $repository) {
            $service = new CategoryChangePositionService($repository);
            return $service($command->getId(), $command->getPosition());
        });

        return $category;
    }
}