<?php
namespace App\Users\Infostructure\Service;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Users\Domain\Service\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {}

    public function hashPassword(AuthUserInterface $user, string $plainPassword): string
    {
        return $this->passwordHasher->hashPassword($user, $plainPassword);
    }

    public function isPasswordValid(AuthUserInterface $user, string $plainPassword): bool
    {
        return $this->passwordHasher->isPasswordValid($user, $plainPassword);
    }
        
}
