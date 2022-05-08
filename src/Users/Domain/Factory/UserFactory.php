<?php
namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Entity\UserEmail;
use App\Users\Domain\Service\PasswordHasherInterface;
use InvalidArgumentException;

class UserFactory 
{
    public function __construct(
        private readonly PasswordHasherInterface $_passwordHasher,
    )
    {
        if ($this->_passwordHasher === null) {
            throw new InvalidArgumentException("null");
        }
    }

    public function create(
        string $email,
        string $nickname,
        string $plainPassword,
        string $role,
        int $status,
    ): User
    {
        return (new User())
            ->setEmail($email)
            ->setNickname($nickname)
            ->setRole($role)
            ->setStatus($status)
            ->setPassword($this->_passwordHasher, $plainPassword)
        ;
    }

    public function signup(UserEmail $email, string $plainPassword): User
    {
        return (new User())
            ->setEmail($email->getValue())
            ->setNickname($email->getNickname())
            ->setRoleAsUser()
            ->setStatusAsInactive()
            ->setPassword($this->_passwordHasher, $plainPassword)
            ->generateActivationToken()
        ;
    }
}