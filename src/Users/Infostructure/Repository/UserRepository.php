<?php
namespace App\Users\Infostructure\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Shared\Domain\Exception\NotFoundDomainException;
use App\Shared\Infostructure\Repository\Repository;

class UserRepository extends Repository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // public function get($id, $lockMode = null, $lockVersion = null): User
    // {
    //     $user = $this->find($id, $lockMode, $lockVersion);

    //     if ($user == null) {
    //         throw new NotFoundDomainException("User by id = $id has not been found.");
    //     }

    //     return $user;
    // }

    public function getById(int $id): User
    {
        $user = $this->find($id);

        NotFoundDomainException::notNull($user, "User by id = `$id` has not been found.");

        return $user;
    }

    public function getByActivationToken(string $token): User
    {
        $user = $this->findByActivationToken($token);

        NotFoundDomainException::notNull($user, "User by token = `$token` has not been found.");

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

        NotFoundDomainException::notNull($user, "User by email {$email} has not been found.");

        return $user;
    }

    public function findByEmail(string $email): ?User
    {   
        return $this->findOneBy([
            "email" => $email,
        ]);
    }

    public function findAllNotDeletedUsers(int $page, int $itemsPerPage, string $idOrder = "DESC"): Paginator
    {
        $firstResult = ($page - 1) * $itemsPerPage;

        $query = $this->createQueryBuilder("u")
            ->where("u.status != :status")
            ->setParameter("status", User::STATUS_DELETED)
            ->orderBy("u.id", $idOrder)
            ->getQuery()
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage);
        
        return new Paginator(new DoctrinePaginator($query));
    }
}