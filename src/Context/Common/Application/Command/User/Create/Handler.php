<?php
namespace App\Context\Common\Application\Command\User\Create;

use App\Context\Common\Application\Event\UserCreatedDomainEvent;
use App\Context\Common\Application\Event\UserCreateDomainEvent;
use App\Context\Common\Domain\Entity\User;
use App\Doctrine\Manager;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
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
        $user = new User();
        $user->setEmail($command->email);
        $user->setNickname($command->nickname);
        $user->setPassword($this->_passwordEncoder->encodePassword($user, $command->password));
        $user->setRole($command->role);
        $user->setStatus($command->status);
        $this->_em->persist($user);

        if ($command->useVerification) {
            $this->_dispatchUserCreate($user);
        }
        
        $this->_em->flush();

        if ($command->useVerification) {
            $this->_dispatchUserCreated($user);
        }

        return $user;
    }

    private function _dispatchUserCreate(User $user) {
        $event = new UserCreateDomainEvent($user);
        $this->_eventDispatcher->dispatch($event, $event->getName());
    }

    private function _dispatchUserCreated(User $user) {
        $event = new UserCreatedDomainEvent($user);
        $this->_eventDispatcher->dispatch($event, $event->getName());
    }

}