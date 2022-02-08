<?php
namespace App\Context\Common\Application\Command\User\Signup;

use App\Context\Common\Application\Event\SignupDomainEvent;
use App\Context\Common\Application\Event\SignupedDomainEvent;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Entity\UserEmail;
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
        $user = User::signup(
            email: new UserEmail($command->getEmail()),
            password: function(User $user) use ($command) {
                return $this->_passwordHasher->hashPassword($user, $command->getPassword());
            },
        );

        $this->_eventDispatcher->dispatch(new SignupDomainEvent($user));

        $this->_em->persist($user);
        $this->_em->flush();

        $this->_eventDispatcher->dispatch(new SignupedDomainEvent($user));

        return $user;
    }
}