<?php
namespace App\Context\Common\Application\Event;

use App\Context\Common\Domain\Entity\User;
use App\Util\EventDispatcher\DomainEvent;

class SignupedDomainEvent extends DomainEvent
{
    protected string $rawPassword;


    public function __construct(string $name, User $target, string $rawPassword)
    {
        parent::__construct($name, $target);

        $this->rawPassword = $rawPassword;
    }

    public function getEntityId(): int
    {
        return $this->target->getId();
    }

    public function getToken(): string
    {
        return $this->target->getActivationToken()->getValue();
    }

    public function getRawPassword(): string
    {
        return $this->rawPassword;
    }
}