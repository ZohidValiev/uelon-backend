<?php
namespace App\Context\Common\Application\Command\User\Activate;


class Command
{
    public function __construct(private string $token)
    {}

    public function getToken(): string
    {
        return $this->token;
    }
}