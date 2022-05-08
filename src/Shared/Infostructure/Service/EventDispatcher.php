<?php
namespace App\Shared\Infostructure\Service;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\Event\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as NativeEventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private NativeEventDispatcherInterface $_eventDispatcher
    )
    {}

    public function dispatch(DomainEvent $event): object
    {
        return $this->_eventDispatcher->dispatch($event, $event->getName());
    }
}
