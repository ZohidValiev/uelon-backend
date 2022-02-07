<?php
namespace App\Context\Common\Application\Command\User\UpdateNickname;


class Command 
{
    public function __construct(
        private int $id,
        private string $nickname,
    )
    {}
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getNickname(): string
    {
        return $this->nickname;
    }
}