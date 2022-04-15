<?php
namespace App\Context\Common\Application\Command\User\Activate;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(
        private Manager $_em, 
        private UserRepositoryInterface $_repository,
    )
    {}
    
    public function handle(Command $command): User
    {
        return $this->_em->wrapInTransaction(function() use ($command) {
            $user = $this->_repository->getByActivationToken($command->getToken());
            $user->activate();
            return $user;
        });
    }
}