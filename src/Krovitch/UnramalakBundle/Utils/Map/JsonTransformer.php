<?php

namespace Krovitch\UnramalakBundle\Utils\Map;

use Krovitch\UnramalakBundle\Behavior\EntityManagerBehavior;
use Krovitch\UnramalakBundle\Entity\Map;
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

    public function transform($data)
    {
        $this->check($data);
        /** @var Map $map */
        $map = $this->getMapManager()->findWithCells($data->profile->id);

        if (!$map) {
            throw new \Exception('Map not found');
        }
        $map->setName($data->profile->name);
        $map->setWidth($data->profile->width);
        $map->setHeight($data->profile->height);
        //$map->set
    }

    protected function check($data)
    {
        print_r($data);
        // checking required data
        $this->throwUnless($data->profile, 'Invalid map profile');
        $this->throwUnless($data->profile->id, 'Invalid map id');


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
}