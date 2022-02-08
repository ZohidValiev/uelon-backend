<?php
namespace App\Context\Common\Infostructure\Repository;

use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function get($id, $lockMode = null, $lockVersion = null): User
    {
        $user = $this->find($id, $lockMode, $lockVersion);

        if ($user == null) {
            throw new NotFoundDomainException("User by id = $id has not been found.");
        }

        return $user;
    }

    public function getByActivationToken(string $token): User
    {
        $user = $this->findByActivationToken($token);

        if ($user == null) {
            throw new NotFoundDomainException("User has not been found.");
        }

        return $user;
    }

    public function findByActivationToken(string $token): ?User
    {
        return $this->findOneBy([
            'activationToken' => $token,
        ]);
    }

    public function getByEmail(string $email): User
    {
        $user = $this->findByEmail($email);

        if ($user === null) {
            throw new \DomainException("User by email {$email} has not been found.");
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {   
        return $this->findOneBy([
            "email" => $email,
        ]);
    }
}