<?php
namespace App\Shared\Domain\Event;


interface EventBusInterface
{
    public function handle(EventInterface $event): void;
}