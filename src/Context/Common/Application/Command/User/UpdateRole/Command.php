<?php
namespace App\Context\Common\Application\Command\User\UpdateRole;


class Command 
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