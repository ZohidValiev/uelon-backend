<?php
namespace App\Context\Common\Application\Command\User\UpdateStatus;


class Command 
{
    public function __construct(
        private int $id,
        private int $status,
    )
    {}
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getStatus(): int
    {
        return $this->status;
    }
}