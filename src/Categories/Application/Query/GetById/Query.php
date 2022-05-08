<?php
namespace App\Categories\Application\Query\GetById;

use App\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(public readonly int $id)
    {}
}