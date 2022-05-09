<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\EventInterface;
use App\Users\Domain\Entity\User;
use DateTimeImmutable;

class SignupedDomainEvent implements EventInterface
{
    public function __construct(private readonly User $_user)
    {}

    public function getEmail(): string
    {
        return $this->_user->getEmail();
    }

    public function getNickname(): string
    {
        return $this->_user->getNickname();
    }

    public function getToken(): string
    {
        return $this->_user->getActivationToken()->getValue();
    }

    public function getTokenExpireTime(): DateTimeImmutable
    {
        return $this->_user->getActivationToken()->getExpireTime();
    }
}