<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Users\Domain\Entity\User;

class SignupedDomainEvent extends DomainEvent
{
    public function __construct(User $target)
    {
        parent::__construct(UserEvents::EVENT_USER_SIGNUPED, $target);
    }
}