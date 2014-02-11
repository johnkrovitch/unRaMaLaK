<?php

namespace Krovitch\UnramalakBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MapRepository extends EntityRepository
{
    /**
     * Return a map with its cells and starting position
     *
     * @param $id
     * @return mixed
     */
    public function findWithCells($id)
    {
        return $this->createQueryBuilder('map')
            ->addSelect('cells', 'point')
            ->leftJoin('map.cells', 'cells')
            ->leftJoin('map.startingPoint', 'point')
            ->where('map.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}