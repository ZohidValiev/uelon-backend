<?php
namespace App\Context\Common\Application\Command\User\ChangePassword;


class Command
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