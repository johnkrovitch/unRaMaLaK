<?php

namespace Krovitch\KrovitchBundle\Manager;

use \Krovitch\KrovitchBundle\Entity\Map;
use Krovitch\KrovitchBundle\Utils\MapDataXml;

/**
 * Class MapManager
 * @package Krovitch\KrovitchBundle\Manager
 */
class MapManager extends BaseManager
{
    /**
     * Save map into database, also save its data into xml file
     * @param $map
     */
    public function save($map)
    {
        // save map first, so it has an id
        parent::save($map);
        // map data are stored in a xml file
        $mapDataXml = new MapDataXml($map, $this->getMapDataFilePath());
        $mapDataXml->save();
    }

    /**
     * Create a json object containing data for map
     */
    public function createJsonData(Map $map)
    {
        // get map data json template file
        $template = file_get_contents($this->getMapDataTemplatePath() . 'mapData.template.json');
        // decode data
        $data = json_decode($template);
        // fill data
        $data = [
            'name' => $map->getName(),
            'width' => $map->getWidth(),
            'height' => $map->getHeight(),
            'cells' => ''
        ];
        // TODO fill JSON data
    }

    public function getMapDataFilePath()
    {
        return __DIR__ . '/../Resources/maps/';
    }

    public function getMapDataTemplatePath()
    {
        return __DIR__ . '/Resources/templates/';
    }
}