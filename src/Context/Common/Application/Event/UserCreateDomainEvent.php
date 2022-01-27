<?php
namespace App\Context\Common\Application\Event;

use App\Context\Common\Domain\Entity\User;
use App\Util\EventDispatcher\DomainEvent;

class UserCreateDomainEvent extends DomainEvent
{   
    public function __construct(User $user)
    {
        parent::__construct(UserEvents::EVENT_USER_CREATE, $user);
    }
}