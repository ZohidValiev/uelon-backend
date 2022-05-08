<?php
namespace App\Users\Application\Command\User\Signup;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(public readonly string $email, public readonly string $password)
    {}
}