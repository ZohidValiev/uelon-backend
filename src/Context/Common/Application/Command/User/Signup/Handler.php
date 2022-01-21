<?php
namespace App\Context\Common\Application\Command\User\Signup;

use App\Context\Common\Application\Event\SignupCompletedDomainEvent;
use App\Context\Common\Application\Event\SignupedDomainEvent;
use App\Context\Common\Application\Event\SignupStartedDomainEvent;
use App\Context\Common\Application\Event\UserEvents;
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
        $this->_dispatchSignupStarted($command->email, $command->password);

        $user = new User(
            email: new UserEmail($command->email),
            roles: User::getRolesUser(),
            activationToken: Token::generate(3600 * 24)
        );
        $user->setPassword($this->_passwordEncoder->encodePassword($user, $command->password));

        $this->_dispatchSignuped($user, $command->password);

        $this->_em->persist($user);
        $this->_em->flush();

        $this->_dispatchSignupCompleted($user, $command->password);

        return $user;
    }

    private function _dispatchSignupStarted(string $email, string $rawPassword): SignupStartedDomainEvent
    {
        return $this->_eventDispatcher->dispatch(
            new SignupStartedDomainEvent(
                UserEvents::EVENT_SIGNUP_STARTED,
                $email,
                $rawPassword,
            ),
            UserEvents::EVENT_SIGNUP_STARTED
        );
    }

    private function _dispatchSignuped(User $user, string $rawPassword)
    {
        return $this->_eventDispatcher->dispatch(
            new SignupedDomainEvent(
                UserEvents::EVENT_SIGNUPED, 
                $user, 
                $rawPassword,
            ),
            UserEvents::EVENT_SIGNUPED
        );
    }

    private function _dispatchSignupCompleted(User $user, string $rawPassword): SignupCompletedDomainEvent
    {
        return $this->_eventDispatcher->dispatch(
            new SignupCompletedDomainEvent(
                UserEvents::EVENT_SIGNUP_COMPLETED, 
                $user,
                $rawPassword,
            ), 
            UserEvents::EVENT_SIGNUP_COMPLETED
        );
    }
}