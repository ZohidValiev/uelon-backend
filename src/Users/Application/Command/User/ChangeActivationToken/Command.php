<?php
namespace App\Users\Application\Command\User\ChangeActivationToken;


final class Command
{
    public function __construct(private string $email)
    {}

    /**
     * Get the value of email
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }
}