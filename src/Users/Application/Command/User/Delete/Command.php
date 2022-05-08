<?php
namespace App\Users\Application\Command\User\Delete;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(public readonly int $id)
    {}
}