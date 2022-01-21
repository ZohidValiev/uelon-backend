<?php
namespace App\Context\Common\Application\Query\User\GetByToken;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;

class Handler
{
    public function __construct(private UserRepositoryInterface $_repository)
    {}

    public function handle(Query $query): ?User
    {
        return $this->_repository->findByActivationToken($query->getToken());
    }
}