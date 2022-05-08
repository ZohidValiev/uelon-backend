<?php
namespace App\Categories\Application\Command\ChangePosition;

use App\Categories\Domain\Entity\Service\CategoryChangePositionService;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private CategoryChangePositionService $changePositionService,
    )
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $category = $this->_repository->getById($command->id);

        $changePositionService = $this->changePositionService;
        $category = $changePositionService($category, $command->position);

        return $category;
    }
}