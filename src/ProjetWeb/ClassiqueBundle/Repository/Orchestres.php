<?php
namespace ProjetWeb\ClassiqueBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class Orchestres extends EntityRepository
{

    /**
     * @return Pagerfanta
     */
    public function findAllAdapter()
    {
        $query = $this->createQueryBuilder('o');
        $query->orderBy("o.nomOrchestre", 'ASC');

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));

        return $pagerfanta;
    }

    /**
     * @param $initial
     *
     * @return Pagerfanta
     */
    public function findOrchestresByInitialAdapter($initial)
    {
        $query = $this->createQueryBuilder('o');
        $query->where('o.nomOrchestre LIKE :initial');
        $query->setParameter('initial', $initial . '%');
        $query->orderBy("o.nomOrchestre", 'ASC');

        $pagerfanta = new Pagerfanta(new DoctrineORMAdapter($query));

        return $pagerfanta;
    }
}