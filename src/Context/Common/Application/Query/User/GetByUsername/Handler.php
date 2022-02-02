<?php
namespace App\Context\Common\Application\Query\User\GetByUsername;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Doctrine\Manager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Handler
{
    public function __construct(
        private Manager $_em,
        private UserPasswordEncoderInterface $_passwordEncoder,
        private UserRepositoryInterface $_repository, 
    )
    {}

    public function handle(Query $query): ?User
    {
        $user = $this->_repository->getByEmail($query->getUsername());
        $hashedPassword = $this->_passwordEncoder->encodePassword($user, $query->getPassword());

        // if ($user->getPassword() !== $hashedPassword) {
        //     return null;
        // }

        return $user;
    }
}