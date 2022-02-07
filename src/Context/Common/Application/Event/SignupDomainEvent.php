<?php
namespace App\Context\Common\Application\Event;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Entity\UserEmail;
use App\Util\EventDispatcher\DomainEvent;

class SignupDomainEvent extends DomainEvent
{
    public function __construct(User $user)
    {
        parent::__construct(UserEvents::EVENT_USER_SIGNUP, $user);
    }
}