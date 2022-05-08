<?php
namespace App\Users\Application\Query\User\GetByToken;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $_repository)
    {}

    public function __invoke(Query $query): ?User
    {
        return $this->_repository->findByActivationToken($query->getToken());
    }
}