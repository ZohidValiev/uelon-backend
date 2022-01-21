<?php
namespace App\Util;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordEncoder
{
    public function __construct(private UserPasswordEncoderInterface $_encoder)
    {
        
    }

    public function encodePassword(UserInterface $user, string $plainPassword)
    {
        return $this->_encoder->encodePassword($user, $plainPassword);
    }
}