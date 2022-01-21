<?php
namespace App\Util\EventDispatcher;


interface EventDispatcherInterface
{
    public function dispatch(object $event, string $eventName = null): object;
}