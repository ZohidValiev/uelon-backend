<?php
namespace App\Context\Common\Application\Command\User\Signup;

use App\Context\Common\Application\Event\SignupDomainEvent;
use App\Context\Common\Application\Event\SignupedDomainEvent;
use App\Context\Common\Domain\Entity\Token;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Entity\UserEmail;
use App\Doctrine\Manager;
use App\Util\EventDispatcher\EventDispatcherInterface;
use App\Util\PasswordEncoder;

class Handler
{
    public function __construct(
        private Manager $_em,
        private PasswordEncoder $_passwordEncoder,
        private EventDispatcherInterface $_eventDispatcher,
    )
    {}

    public function handle(Command $command): User
    {
        $user = User::signup(
            email: new UserEmail($command->getEmail()),
            password: $this->_passwordEncoder->encodePassword(new User(), $command->getPassword()),
        );

        $this->_eventDispatcher->dispatch(new SignupDomainEvent($user));

        $this->_em->persist($user);
        $this->_em->flush();

        $this->_eventDispatcher->dispatch(new SignupedDomainEvent($user));

        return $user;
    }
}