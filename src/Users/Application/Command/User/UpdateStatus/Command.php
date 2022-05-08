<?php
namespace App\Users\Application\Command\User\UpdateStatus;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        private int $id,
        private int $status,
    )
    {}
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getStatus(): int
    {
        return $this->status;
    }
}