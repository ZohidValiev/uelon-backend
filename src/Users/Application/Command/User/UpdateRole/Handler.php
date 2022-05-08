<?php
namespace App\Users\Application\Command\User\UpdateRole;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $_repository)
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $user = $this->_repository->getById($command->getId());

        $user->setRole($command->getRole());

        return $user;
    }
}