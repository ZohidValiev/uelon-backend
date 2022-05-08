<?php
namespace App\Categories\Application\Command\Delete;

use App\Categories\Domain\Entity\Service\CategoryDeleteService;
use App\Categories\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $_repository,
        private CategoryDeleteService $_categoryDeleteService,
    )
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $category = $this->_repository->getById($command->id);

        $categoryDeleteService = $this->_categoryDeleteService;
        $categoryDeleteService($category);

        return $category;
    }
}