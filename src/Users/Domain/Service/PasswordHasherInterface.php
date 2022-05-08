<?php
namespace App\Users\Domain\Service;

use App\Shared\Domain\Security\AuthUserInterface;

interface PasswordHasherInterface
{
    public function hashPassword(AuthUserInterface $user, string $plainPassword): string;

    public function isPasswordValid(AuthUserInterface $user, string $plainPassword): bool;
}