<?php
namespace App\Context\Common\Application\Command\User\Create;

use App\Context\Common\Application\Event\UserCreatedDomainEvent;
use App\Context\Common\Application\Event\UserCreateDomainEvent;
use App\Context\Common\Domain\Entity\User;
use App\Doctrine\Manager;
use App\Util\EventDispatcher\EventDispatcherInterface;
use App\Util\PasswordHasher;

class Handler
{
    public function __construct(
        private Manager $_em, 
        private PasswordHasher $_passwordHasher,
        private EventDispatcherInterface $_eventDispatcher,
    )
    {}

    public function handle(Command $command): User
    {
        $user = User::create(
            email: $command->getEmail(),
            nickname: $command->getNickname(),
            role: $command->getRole(),
            status: $command->getStatus(),
            password: function(User $user) use ($command) {
                return $this->_passwordHasher->hashPassword($user, $command->getPassword());
            },
        );

        if ($command->getUseVerification()) {
            $this->_eventDispatcher->dispatch(new UserCreateDomainEvent($user));
        }
        
        $this->_em->wrapInTransaction(function() use ($user) {
            $this->_em->persist($user);
        });

        if ($command->getUseVerification()) {
            $this->_eventDispatcher->dispatch(new UserCreatedDomainEvent($user));
        }

        return $user;
    }
}