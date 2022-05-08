<?php
namespace App\Users\Application\Command\User\UpdateRole;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        private int $id,
        private string $role,
    )
    {}
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getRole(): string
    {
        return $this->role;
    }
}