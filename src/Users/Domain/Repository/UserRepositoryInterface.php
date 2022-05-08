<?php
namespace App\Users\Domain\Repository;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Shared\Domain\Exception\NotFoundDomainException;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Users\Domain\Entity\User;

interface UserRepositoryInterface extends RepositoryInterface
{
    // /**
    //  * @throws NotFoundDomainException
    //  */
    // public function get($id, $lockMode = null, $lockVersion = null): User;

    /**
     * @throws NotFoundDomainException
     */
    public function getById(int $id): User;

    /**
     * @throws NotFoundDomainException
     */
    public function getByActivationToken(string $token): User;

    public function findByActivationToken(string $token): ?User;

    /**
     * @throws NotFoundDomainException
     */
    public function getByEmail(string $email): User;

    public function findByEmail(string $email): ?User;

    public function findAllNotDeletedUsers(int $page, int $itemsPerPage, string $idOrder = "DESC"): Paginator;
}