<?php
namespace App\Categories\Application\Query\FindChildren;

use App\Shared\Application\Query\QueryInterface;

class Query implements QueryInterface
{
    public function __construct(
        public readonly int $parentId, 
        public readonly ?bool $active = null,
    )
    {}
}