<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Users\Domain\Entity\User;

class ActivationTokenChangedDomainEvent extends DomainEvent
{
    public function __construct(User $user)
    {
        parent::__construct(UserEvents::EVENT_USER_CHANGED_ACTIVATION_TOKEN, $user);
    }
}