<?php
namespace App\Users\Domain\Event;

use App\Shared\Domain\Event\EventInterface;
use DateTimeImmutable;

class UserSignupedDomainEvent implements EventInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $nickname,
        public readonly string $token,
        public readonly DateTimeImmutable $tokenExpireTime,
    )
    {}
}