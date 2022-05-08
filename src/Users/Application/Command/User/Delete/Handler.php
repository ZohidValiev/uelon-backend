<?php
namespace App\Users\Application\Command\User\Delete;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Users\Domain\Entity\Service\UserDeleteService;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $_repository,
        private readonly UserDeleteService $_userDeleteService,
    )
    {}

    public function __invoke(Command $command): void
    {
        $user = $this->_repository->getById($command->id);
        $userDeleteService = $this->_userDeleteService;
        $userDeleteService($user);
    }
}