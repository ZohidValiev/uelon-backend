<?php
namespace App\Doctrine;

use Closure;
use Doctrine\ORM\EntityManagerInterface;

class Manager
{
    public function __construct(private EntityManagerInterface $_em)
    {}

    /**
     * @deprecated Do not use this method. Since doctrine version 2.10 this method is deprecated.
     */
    public function transactional($callback)
    {
        return $this->_em->transactional($callback);
    }

    /**
     * @return mixed
     */
    public function wrapInTransaction(callable $func)
    {
        return $this->_em->wrapInTransaction($func);
    }

    public function persist($entity)
    {
        $this->_em->persist($entity);
    }

    public function remove($entity)
    {
        $this->_em->remove($entity);
    }

    public function flush()
    {
        $this->_em->flush();
    }
}