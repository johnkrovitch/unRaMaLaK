<?php

namespace Krovitch\UnramalakBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MapRepository extends EntityRepository
{
    /**
     * Return a map with its cells and starting position
     *
     * @param $id
     * @param int $limitX
     * @param int $limitY
     * @return mixed
     */
    public function findMap($id, $limitX = 0, $limitY = 0)
    {
        $queryBuilder = $this->createQueryBuilder('map')
            ->addSelect('cell', 'point')
            ->leftJoin('map.cells', 'cell')
            ->leftJoin('map.startingPoint', 'point')
            ->where('map.id = :id')
            ->setParameter('id', $id);

        if ($limitX) {
            $queryBuilder
                ->andWhere('cell.x < :limitX')
                ->setParameter('limitX', $limitX);
        }
        if ($limitY) {
            $queryBuilder
                ->andWhere('cell.y < :limitY')
                ->setParameter('limitY', $limitY);
        }
        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }
}