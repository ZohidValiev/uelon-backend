<?php
namespace App\Util;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordHasher
{
    public function __construct(private UserPasswordHasherInterface $_encoder)
    {
        
    }

    public function hashPassword(UserInterface $user, string $plainPassword)
    {
        return $this->_encoder->hashPassword($user, $plainPassword);
    }
}