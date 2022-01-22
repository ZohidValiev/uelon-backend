<?php
namespace App\Context\Common\Application\Command\User\UpdateRole;

use App\Context\Common\Domain\Entity\User;
use App\Doctrine\Manager;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;


class Handler
{
    public function __construct(
        private Manager $_em, 
        private UserRepositoryInterface $_repository,
    )
    {}

    public function handle(Command $command): User
    {
        return $this->_em->transactional(function() use ($command) {
            $user = $this->_repository->get($command->id);
            $user->setRole($command->role);
            return $user;
        });
    }
}