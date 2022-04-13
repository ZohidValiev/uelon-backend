<?php
namespace App\Context\Category\Application\Query\FindChildren;


class Query 
{
    public function __construct(private int $parentId, private ?bool $active = null)
    {}

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getActive(): bool|null
    {
        return $this->active;
    }
}