<?php

namespace Krovitch\UnramalakBundle\Utils\Map;

use Doctrine\ORM\EntityManager;
use Krovitch\UnramalakBundle\Entity\Cell;
use Krovitch\UnramalakBundle\Entity\Land;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Entity\Position;
use Krovitch\UnramalakBundle\Manager\LandManager;
use Krovitch\UnramalakBundle\Manager\MapManager;
use Krovitch\UnramalakBundle\Utils\TransformerInterface;

/**
 * JsonTransformer
 *
 * Return a map from data and database
 */
class JsonTransformer implements TransformerInterface
{
    protected $mapManager;

    protected $landManager;

    /**
     * Transforms json data in an Unramalak map, then saves it with its cell (if map has cells)
     *
     * @param $data
     * @throws \Exception
     */
    public function transform($data)
    {
        $this->check($data);
        /** @var Map $map */
        $map = $this->getMapManager()->findWithCells($data->profile->id);

        if (!$map) {
            throw new \Exception('Map not found');
        }
        // map profile data
        $map->setName($data->profile->name);
        $map->setWidth($data->profile->width);
        $map->setHeight($data->profile->height);
        $map->setContent('test ???' . time());
        // map own data
        $map->setCellPadding($data->cellPadding);
        $map->setNumberOfSides($data->numberOfSides);
        $map->setStartingPoint(new Position($data->startingPoint->x, $data->startingPoint->y));
        $map->setRadius($data->radius);


        if ($data->cells) {
            // TODO make save with differential
            try {
                // existing lands
                $lands = $this->getLandManager()->findSortedByType();
                $this->getMapManager()->getEntityManager()->getConnection()->beginTransaction();
                // removing existing cells
                $map->removeCells();
                $this->getMapManager()->save($map);

                foreach ($data->cells as $cellData) {
                    $cell = new Cell();
                    $cell->setX($cellData->x);
                    $cell->setY($cellData->y);
                    $cell->setX($cellData->x);
                    $cell->setX($cellData->x);
                    $cell->setLand($lands[$cellData->land->type]);
                    $map->addCell($cell);
                }
                $this->getMapManager()->save($map);
                $this->getMapManager()->getEntityManager()->getConnection()->commit();
            }
            catch (\Exception $e) {
                $this->getMapManager()->getEntityManager()->getConnection()->rollback();
            }
        }
    }

    /**
     * Check if json data are valid. In principle, no more data checks are required after calling this method
     *
     * @param $data
     */
    protected function check($data)
    {
        //print_r($data);
        // checking required data
        $this->throwUnless($data->profile, 'Invalid map profile');
        $this->throwUnless($data->profile->id, 'Invalid map id');

        if ($data->cells) {
            $this->throwUnless(is_array($data->cells) && count($data->cells), 'Invalid cells array');
            $lands = $this->getLandManager()->findSortedByType();
            $this->throwUnless(count($lands), 'No reference land found');

            foreach ($data->cells as $cell) {
                $this->throwUnless(is_int($cell->x) && is_int($cell->y), 'Invalid cell : ' . print_r($cell, true));
                $this->throwUnless($cell->land && array_key_exists($cell->land->type, $lands), 'Invalid land type : ' . print_r($cell, true));
            }
        }
    }

    protected function throwUnless($condition, $message)
    {
        if (!$condition) {
            throw new \Exception($message);
        }
    }

    public function setMapManager(MapManager $mapManager)
    {
        $this->mapManager = $mapManager;
    }

    /**
     * @return MapManager
     */
    public function getMapManager()
    {
        return $this->mapManager;
    }

    /**
     * @return LandManager
     */
    public function getLandManager()
    {
        return $this->landManager;
    }

    /**
     * @param LandManager $landManager
     */
    public function setLandManager(LandManager $landManager)
    {
        $this->landManager = $landManager;
    }
}