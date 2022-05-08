<?php
namespace App\Users\Domain\Entity\Service;

use App\Users\Domain\Entity\User;
use DomainException;

class UserDeleteService
{
    /**
     * @throws DomainException
     */
    public function __invoke(User $user): void
    {
        if ($user->isDeleted()) {
            throw new DomainException("Повторное удаление пользователя.");
        }

        $user->setStatus(User::STATUS_DELETED);
    }
}