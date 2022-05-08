<?php
namespace App\Users\Application\Command\User\Create;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $nickname,
        public readonly string $password,
        public readonly string $role,
        public readonly int $status,
        public readonly bool $sendNotification = true,
    )
    {}
}