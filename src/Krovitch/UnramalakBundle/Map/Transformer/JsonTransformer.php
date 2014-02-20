<?php

namespace Krovitch\UnramalakBundle\Map\Transformer;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Krovitch\UnramalakBundle\Entity\Cell;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Entity\Position;
use Krovitch\UnramalakBundle\Interfaces\TransformerInterface;
use Krovitch\UnramalakBundle\Manager\LandManager;
use Krovitch\UnramalakBundle\Manager\MapManager;
use Krovitch\UnramalakBundle\Map\MapContext;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * JsonTransformer
 *
 * Allows conversion map to json and json to map object
 */
class JsonTransformer implements TransformerInterface
{
    /**
     * Map manager
     *
     * @var \Krovitch\UnramalakBundle\Manager\MapManager
     */
    protected $mapManager;

    /**
     * Land manager
     *
     * @var \Krovitch\UnramalakBundle\Manager\LandManager
     */
    protected $landManager;

    /**
     * Initialize a json map transformer with map and land managers
     *
     * @param MapManager $mapManager
     * @param LandManager $landManager
     */
    public function __construct(MapManager $mapManager, LandManager $landManager)
    {
        $this->mapManager = $mapManager;
        $this->landManager = $landManager;
    }

    /**
     * Transforms json data in an Unramalak map, then saves it with its cell (if map has cells)
     *
     * @param $data
     * @return \Krovitch\UnramalakBundle\Entity\Map
     * @throws \Exception
     */
    public function transform($data)
    {
        $data = json_decode($data, false);
        /** @var Map $map */
        $this->check($data);
        $map = $this->mapManager->findMap($data->profile->id);

        if (!$map) {
            throw new \Exception('Map not found');
        }
        // map profile data
        $map->setName($data->profile->name);
        $map->setWidth($data->profile->width);
        $map->setHeight($data->profile->height);
        // map own data
        $map->setCellPadding($data->cellPadding);
        $map->setNumberOfSides($data->numberOfSides);
        $map->setStartingPoint(new Position($data->startingPoint->x, $data->startingPoint->y));
        $map->setRadius($data->radius);

        if ($data->cells) {
            // existing lands
            $lands = $this->landManager->findSortedByType();
            // we sort cells to ease further research
            $cells = [];
            $unsortedCells = $map->getCells();

            /** @var Cell $cell */
            foreach ($unsortedCells as $cell) {
                $x = $cell->getX();
                $y = $cell->getY();

                if (!array_key_exists($x, $cells)) {
                    $cells[$x] = [];
                }
                if (!array_key_exists($y, $cells)) {
                    $cells[$y] = [];
                }
                $cells[$x][$y] = $cell;
            }
            // save new cells data
            foreach ($data->cells as $cellData) {
                // find existing cell
                if (!array_key_exists($cellData->x, $cells)) {
                    throw new InvalidArgumentException('Invalid row : ' . $cellData->x);
                }
                if (!array_key_exists($cellData->y, $cells[$cellData->x])) {
                    throw new InvalidArgumentException('Invalid column : ' . $cellData->y);
                }
                $cell = $cells[$cellData->x][$cellData->y];
                $cell->setLand($lands[$cellData->land->type]);
            }
        }
        return $map;
    }

    /**
     * Return a json map context from a map entity
     *
     * @param Map $map
     * @return string
     * @throws \Exception
     */
    public function reverseTransform($map)
    {
        $this->reverseCheck($map);
        // map profile
        $mapContext = new MapContext();
        $mapContext->profile = [
            'id' => $map->getId(),
            'name' => $map->getName(),
            'width' => $map->getWidth(),
            'height' => $map->getHeight(),
        ];
        // map characteristic
        $mapContext->cellPadding = $map->getCellPadding();
        $mapContext->numberOfSides = $map->getNumberOfSides();
        $mapContext->startingPoint = [
            'x' => $map->getStartingPoint()->getX(),
            'y' => $map->getStartingPoint()->getY()
        ];
        $mapContext->radius = $map->getRadius();
        // cells
        $cells = $map->getCells();
        $cellsData = [];

        /** @var Cell $cell */
        foreach ($cells as $index => $cell) {
            $cellsData[(string)$index] = [
                'x' => $cell->getX(),
                'y' => $cell->getY(),
                'type' => $cell->getLand()->getType()
            ];
        }
        $mapContext->cells = $cellsData;

        return json_encode($mapContext);
    }

    /**
     * Check if json data are valid. In principle, no more data checks are required after calling this method
     *
     * @param $data
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    protected function check($data)
    {
        if (!$data || empty($data->profile) || empty($data->profile->id)) {
            throw new InvalidParameterException('Invalid map profile');
        }
        // checking required data
        $this->throwUnless($data->profile, 'Invalid map profile');
        $this->throwUnless($data->profile->id, 'Invalid map id');

        if ($data->cells) {
            $this->throwUnless(is_array($data->cells) && count($data->cells), 'Invalid cells array');
            $lands = $this->landManager->findSortedByType();
            $this->throwUnless(count($lands), 'No reference land found');

            foreach ($data->cells as $cell) {
                $this->throwUnless(is_int($cell->x) && is_int($cell->y), 'Invalid cell : ' . print_r($cell, true));
                $this->throwUnless($cell->land && array_key_exists($cell->land->type, $lands), 'Invalid land type : ' . print_r($cell, true));
            }
        }
    }

    /**
     * Check if map data are valid. In principle, no more data checks are required after calling this method
     *
     * @param Map $map
     * @throws \Exception
     */
    protected function reverseCheck($map)
    {
        $this->throwUnless($map instanceof Map, 'Invalid map type');
        $this->throwUnless($map->getStartingPoint(), 'Invalid map starting point');
        $this->throwUnless($map->getCells(), 'Invalid map cells');
    }

    /**
     * Throw an exception if $condition is not true. Avoid code repetition
     *
     * @param $condition
     * @param $message
     * @throws \Exception
     */
    protected function throwUnless($condition, $message)
    {
        if (!$condition) {
            throw new \Exception($message);
        }
    }
}