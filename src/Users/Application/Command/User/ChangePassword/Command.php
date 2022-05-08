<?php
namespace App\Users\Application\Command\User\ChangePassword;

use App\Shared\Application\Command\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(private string $currentPassword, private string $newPassword)
    {}

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}