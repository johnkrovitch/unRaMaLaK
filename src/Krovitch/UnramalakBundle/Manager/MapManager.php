<?php

namespace Krovitch\UnramalakBundle\Manager;

use GeorgetteParty\BaseBundle\Manager\BaseManager;
use Krovitch\UnramalakBundle\Behavior\LandManagerContainer;
use Krovitch\UnramalakBundle\Entity\Cell;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Entity\Position;
use Krovitch\UnramalakBundle\Repository\MapRepository;
use Krovitch\UnramalakBundle\Interfaces\TransformerInterface;

/**
 * Class MapManager
 * @package Krovitch\UnramalakBundle\Manager
 */
class MapManager extends BaseManager
{
    use LandManagerContainer;
    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * Save map into database
     *
     * @param $data
     */
    public function saveMap($data)
    {
        /** @var Map $map */
        $map = $this->getTransformer()->transform($data);
        $this->save($map);
    }

    /**
     * Save map, and creates defaults data if required
     *
     * @param Map $map
     * @param bool $andFlush
     * @return BaseManager
     */
    public function save($map, $andFlush = true)
    {
        if (!count($map->getCells())) {
            $width = $map->getWidth();
            $height = $map->getHeight();
            $x = 0;

            while ($x < $width) {
                $y = 0;

                while ($y < $height) {
                    $cell = new Cell();
                    $land = $this->getLandManager()->findDefaultLandType();
                    $cell->setLand($land);
                    $cell->setX($x);
                    $cell->setY($y);
                    $map->addCell($cell);
                    $y++;
                }
                $x++;
            }
        }
        if (!$map->getStartingPoint()) {
            $map->setStartingPoint(new Position(100, 100));
        }
        return parent::save($map, $andFlush);
    }

    /**
     * Return a map with its cells
     *
     * @param $id
     * @return mixed
     */
    public function findMap($id)
    {
        $limitX = 5;
        $limitY = 5;

        return $this->getMapRepository()->findMap($id, $limitX, $limitY);
    }

    /**
     * Return a map context for the view
     */
    public function load(Map $map)
    {
        return $this->getTransformer()->reverseTransform($map);
    }

    /**
     * Set map transformer
     *
     * @param TransformerInterface $transformer
     */
    public function setTransformer(TransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Return map transformer
     *
     * @return TransformerInterface
     */
    public function getTransformer()
    {
        return $this->transformer;
    }

    /**
     * Return map repository
     *
     * @return MapRepository
     */
    public function getMapRepository()
    {
        return $this->getRepository('Krovitch\UnramalakBundle\Entity\Map');
    }
}