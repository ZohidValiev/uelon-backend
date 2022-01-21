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

        $category = $this->_em->transactional(function() use ($command, $repository) {
            $service = new CategoryChangePositionService($repository);
            return $service($command->id, $command->position);
        });

        return $category;
    }
}