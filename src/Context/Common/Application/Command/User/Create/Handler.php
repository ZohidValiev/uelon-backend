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
        $user = User::create(
            email: $command->getEmail(),
            nickname: $command->getNickname(),
            password: $this->_passwordEncoder->encodePassword(new User(), $command->getPassword()),
            role: $command->getRole(),
            status: $command->getStatus(),
        );

        if ($command->getUseVerification()) {
            $this->_eventDispatcher->dispatch(new UserCreateDomainEvent($user));
        }
        
        $this->_em->persist($user);
        $this->_em->flush();

        if ($command->getUseVerification()) {
            $this->_eventDispatcher->dispatch(new UserCreatedDomainEvent($user));
        }

        return $user;
    }
}