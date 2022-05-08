<?php
namespace App\Categories\Application\Query\FindRoots;

use App\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(public readonly ?bool $active = null)
    {}
}