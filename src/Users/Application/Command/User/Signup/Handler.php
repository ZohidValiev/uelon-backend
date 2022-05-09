<?php
namespace App\Users\Application\Command\User\Signup;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Event\EventBusInterface;
use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Users\Domain\Entity\UserEmail;
use App\Users\Domain\Event\SignupDomainEvent;
use App\Users\Domain\Event\SignupedDomainEvent;
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

    public function __invoke(Command $command): int
    {
        $user = $this->_userFactory->signup(
            email: new UserEmail($command->email),
            plainPassword: $command->password,
        );

        $this->_repository->save($user, true);
        
        $this->_eventBus->handle(new SignupedDomainEvent($user));

        return $user->getId();
    }
}