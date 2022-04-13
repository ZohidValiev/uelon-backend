<?php
namespace App\Context\Category\Application\Query\FindRoots;


class Query 
{
    public function __construct(private ?bool $active = null)
    {}

    public function getActive(): bool|null
    {
        return $this->active;
    }
}