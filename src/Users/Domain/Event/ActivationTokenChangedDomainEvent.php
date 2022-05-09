<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\EventInterface;
use App\Users\Domain\Entity\User;

class ActivationTokenChangedDomainEvent implements EventInterface
{
    public function __construct(public readonly User $user)
    {}
}