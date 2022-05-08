<?php
namespace App\Users\Application\Query\User\GetNotDeletedUsers;

use App\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(private int $page, private int $limit)
    {}

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}