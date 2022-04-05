<?php
namespace App\Context\Common\Infostructure\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Domain\Repository\UserRepositoryInterface;
use App\Context\Common\Exception\NotFoundDomainException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Doctrine\Common\Collections\Criteria;

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

    public function getNotDeletedUsers(int $page, int $itemsPerPage, string $idOrder = "DESC"): Paginator
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