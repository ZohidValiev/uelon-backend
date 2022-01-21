<?php
namespace App\Context\Common\Application\Event;

use App\Context\Common\Domain\Entity\UserEmail;
use App\Util\EventDispatcher\DomainEvent;

class SignupStartedDomainEvent extends DomainEvent
{
    protected string $email;

    protected string $rawPassword;


    public function __construct(string $event, string $email, string $rawPassword)
    {
        parent::__construct($event);

        $this->email = $email;
        $this->rawPassword = $rawPassword;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRawPassword(): string
    {
        return $this->rawPassword;
    }
}