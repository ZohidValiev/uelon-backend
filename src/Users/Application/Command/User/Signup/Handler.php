<?php
namespace App\Users\Application\Command\User\Signup;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Event\EventBusInterface;
use App\Users\Domain\Entity\UserEmail;
use App\Users\Domain\Event\UserSignupedDomainEvent;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $_repository,
        private EventBusInterface $_eventBus,
        private UserFactory $_userFactory,
    )
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $user = $this->_userFactory->signup(
            email: new UserEmail($command->email),
            plainPassword: $command->password,
        );

        $this->_repository->save($user, true);
        
        $this->_eventBus->handle(new UserSignupedDomainEvent(
            $user->getEmail(),
            $user->getNickname(),
            $user->getActivationToken()->getValue(),
            $user->getActivationToken()->getExpireTime(),
        ));

        return $user;
    }
}