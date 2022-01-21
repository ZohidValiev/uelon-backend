<?php
namespace App\Doctrine;

use Closure;
use Doctrine\ORM\EntityManagerInterface;

class Manager
{
    public function __construct(private EntityManagerInterface $_em)
    {}

    public function transactional($callback)
    {
        return $this->_em->transactional($callback);
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