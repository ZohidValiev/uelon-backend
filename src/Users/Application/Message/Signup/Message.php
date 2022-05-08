<?php
namespace App\Users\Application\Message\Signup;

use DateTimeImmutable;

class Message 
{
    public function __construct(
        public readonly string $email,
        public readonly string $nickname,
        public readonly string $token,
        public readonly DateTimeImmutable $tokenExpireTime,
    )
    {}
}