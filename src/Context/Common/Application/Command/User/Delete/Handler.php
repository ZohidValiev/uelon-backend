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

        $user->setStatus(User::STATUS_DELETED);
        $this->_em->flush();
    }
}