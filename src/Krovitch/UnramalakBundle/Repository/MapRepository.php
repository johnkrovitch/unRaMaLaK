<?php

namespace Krovitch\UnramalakBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MapRepository extends EntityRepository
{
    public function findWithCells($id)
    {
        die('in progress...');
//        return $this->createQueryBuilder('map')
//            ->join('cells')
    }
}