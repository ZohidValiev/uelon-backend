<?php
namespace App\Context\Common\Application\Query\User\GetByUsername;


class Query
{
    public function __construct(private string $username, private string $password)
    {}

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}