<?php
namespace App\Shared\Application\Command;


interface CommandBusInterface
{
    public function handle(CommandInterface $command): mixed;
}