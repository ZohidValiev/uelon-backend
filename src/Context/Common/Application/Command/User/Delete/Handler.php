<?php
namespace App\Context\Common\Application\Command\User\Delete;

use App\Context\Common\Domain\Entity\User;
use App\Doctrine\Manager;
use DomainException;

class Handler 
{
    public function __construct(private Manager $_em)
    {
        
    }

    public function handle(User $user): void
    {
        if ($user->isDeleted()) {
            throw new DomainException("Повторное удаление пользователя.");
        }

        $this->_em->wrapInTransaction(function() use ($user) {
            $user->setStatus(User::STATUS_DELETED);
        });
    }
}