<?php
namespace App\Users\Application\Query\User\GetByToken;

use App\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(private string $token)
    {}

    public function getToken(): string
    {
        return $this->token;
    }
}