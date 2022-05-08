<?php
namespace App\Users\Application\Command\User\Create;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Domain\Entity\EntityIDInterface;
use App\Shared\Domain\Event\EventDispatcherInterface;
use App\Users\Domain\Event\UserCreatedDomainEvent;
use App\Users\Domain\Event\UserCreateDomainEvent;
use App\Users\Domain\Factory\UserFactory;
use App\Users\Domain\Repository\UserRepositoryInterface;
use DomainException;

class Handler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $_repository,
        private EventDispatcherInterface $_eventDispatcher,
        private UserFactory $_userFactory,
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

        // if ($command->sendNotification) {
        //     $this->_eventDispatcher->dispatch(new UserCreateDomainEvent($user));
        // }
        
        try {
            $this->_repository->save($user, true);
        } catch (\Throwable $th) {
            throw new DomainException("Cannot save a user entity in database.");
        }
        
        if ($command->sendNotification) {
            $this->_eventDispatcher->dispatch(new UserCreatedDomainEvent($user));
        }

        return $user;
    }
}