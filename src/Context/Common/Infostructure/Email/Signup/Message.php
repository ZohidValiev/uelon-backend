<?php
namespace App\Context\Common\Infostructure\Email\Signup;

use DateTimeImmutable;

class Message 
{
    public function __construct(
        private int $id,
        private string $email,
        private string $nickname,
        private string $token,
        private DateTimeImmutable $tokenExpireTime,
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getTokenExpireTime(): DateTimeImmutable
    {
        return $this->tokenExpireTime;
    }
}