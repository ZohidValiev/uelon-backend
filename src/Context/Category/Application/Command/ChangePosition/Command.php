<?php
namespace App\Context\Category\Application\Command\ChangePosition;


class Command
{
    public function __construct(
        // Category id
        private int $id, 
        //Category position
        private int $position,
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }
}