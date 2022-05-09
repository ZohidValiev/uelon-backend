<?php
namespace App\Shared\Infostructure\Bus;

use App\Shared\Domain\Event\EventBusInterface;
use App\Shared\Domain\Event\EventInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements EventBusInterface
{
    public function __construct(private readonly MessageBusInterface $eventBus)
    {}

    public function handle(EventInterface $event): void
    {
        $this->eventBus->dispatch($event);
    } 
}