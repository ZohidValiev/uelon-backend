<?php
namespace App\Security;

use App\Context\Common\Domain\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        
        // if (!$user->isRoleAdmin()) {
        //     throw new CustomUserMessageAccountStatusException('Неправельный логин или пароль.');
        // }
    }

    public function checkPostAuth(UserInterface $user)
    {
        
    }
}