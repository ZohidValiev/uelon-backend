<?php
namespace App\Context\Common\Application\Command\User\Activate;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use App\Doctrine\Manager;

class Handler
{
    public function __construct(private Manager $_em)
    {}
    
    public function handle(User $user): User
    {
        $user->activate();

        $this->_em->flush();

        return $user;
    }
}