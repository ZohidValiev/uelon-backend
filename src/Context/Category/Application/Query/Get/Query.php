<?php
namespace App\Context\Category\Application\Query\Get;

class Query
{
    public function __construct(
        private int $id
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }
}