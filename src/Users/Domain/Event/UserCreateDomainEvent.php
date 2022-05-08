<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Users\Domain\Entity\User;

class UserCreateDomainEvent extends DomainEvent
{   
    public function __construct(User $user)
    {
        parent::__construct(UserEvents::EVENT_USER_CREATE, $user);
    }
}