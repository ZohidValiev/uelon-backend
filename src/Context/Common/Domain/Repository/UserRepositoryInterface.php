<?php
namespace App\Context\Common\Domain\Repository;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use App\Context\Common\Domain\Entity\User;
use App\Context\Common\Exception\NotFoundDomainException;

interface UserRepositoryInterface
{
    /**
     * @throws NotFoundDomainException
     */
    public function get($id, $lockMode = null, $lockVersion = null): User;

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

    public function getNotDeletedUsers(int $page, int $itemsPerPage, string $idOrder = "DESC"): Paginator;
}