<?php
namespace App\Util\EventDispatcher;


interface EventDispatcherInterface
{
    public function dispatch(DomainEvent $event): object;
}