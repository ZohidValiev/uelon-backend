<?php
namespace App\Users\Application\Command\User\Activate;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(private string $token)
    {}

    public function getToken(): string
    {
        return $this->token;
    }
}