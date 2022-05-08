<?php
namespace App\Users\Application\Command\User\Activate;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(private UserRepositoryInterface $_repository)
    {}
    
    public function __invoke(Command $command): EntityIDInterface
    {
        /**
         * @var User
         */
        $user = $this->_repository->getByActivationToken($command->getToken());
        $user->activate();

        return $user;
    }
}