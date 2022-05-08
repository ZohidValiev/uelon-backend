<?php
namespace App\Shared\Infostructure\Repository;

use App\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class Repository extends ServiceEntityRepository implements RepositoryInterface
{
    public function save(object $entity, bool $flush = false)
    {
        $this->persist($entity);

        if ($flush) {
            $this->flush();
        }
    }
        
    public function persist(object $entity): void
    {
        $this->_em->persist($entity);
    }
    
    public function remove(object $entity): void
    {
        $this->_em->remove($entity);
    }
    
    public function flush(): void
    {
        $this->_em->flush();
    }
        
    public function wrapInTransaction(callable $func): mixed
    {
        return $this->wrapInTransaction($func);
    }
        
}