<?php
namespace App\Users\Application\Command\User\Create;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Event\EventBusInterface;
use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Users\Domain\Event\UserCreatedDomainEvent;
use App\Users\Domain\Event\UserCreateDomainEvent;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use DomainException;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $_repository,
        private readonly EventBusInterface $_eventBus,
        private readonly UserFactory $_userFactory,
    )
    {}

    public function __invoke(Command $command): EntityIDInterface
    {
        $user = $this->_userFactory->create(
            email: $command->email,
            nickname: $command->nickname,
            role: $command->role,
            status: $command->status,
            plainPassword: $command->password,
        );
        
        $this->_repository->save($user, true);
        
        if ($command->sendNotification) {
            $this->_eventBus->handle(new UserCreatedDomainEvent($user));
        }

        return $user;
    }
}