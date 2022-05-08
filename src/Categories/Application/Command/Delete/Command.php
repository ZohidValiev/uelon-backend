<?php
namespace App\Categories\Application\Command\Delete;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(public readonly int $id)
    {}
}