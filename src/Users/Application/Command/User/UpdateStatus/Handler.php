<?php
namespace App\Users\Application\Command\User\UpdateStatus;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $repository)
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $user = $this->repository->getById($command->getId());

        $user->setStatus($command->getStatus());

        return $user;
    }
}