<?php

namespace App\Util\EventDispatcher;

use Symfony\Component\EventDispatcher as SymfonyEventDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private SymfonyEventDispatcher\EventDispatcherInterface $_eventDispatcher
    )
    {}

    public function dispatch(object $event, ?string $eventName = null): object
    {
        return $this->_eventDispatcher->dispatch($event, $eventName);
    }
}
