<?php
namespace App\Context\Common\Application\Event;

use App\Context\Common\Domain\Entity\User;
use App\Util\EventDispatcher\DomainEvent;

class SignupedDomainEvent extends DomainEvent
{
    public function __construct(User $target)
    {
        parent::__construct(UserEvents::EVENT_USER_SIGNUPED, $target);
    }
}