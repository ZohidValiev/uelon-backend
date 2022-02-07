<?php
namespace App\Context\Common\Application\Command\User\Create;


class Command 
{
    public function __construct(
        private string $email,
        private string $nickname,
        private string $password,
        private string $role,
        private int $status,
        private bool $useVerification = true,
    )
    {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function getRole(): string
    {
        return $this->role;
    }
    
    public function getStatus(): int
    {
        return $this->status;
    }
    
    public function getUseVerification(): bool
    {
        return $this->useVerification;
    }
}