<?php
namespace App\Users\Application\Query\User\GetNotDeletedUsers;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Shared\Application\Query\QueryHandlerInterface;
use App\Users\Domain\Repository\UserRepositoryInterface;

class Handler implements QueryHandlerInterface
{
    public function __construct(private readonly UserRepositoryInterface $_repository)
    {}

    public function __invoke(Query $query): Paginator
    {
        return $this->_repository->findAllNotDeletedUsers($query->getPage(), $query->getLimit());
    }
}