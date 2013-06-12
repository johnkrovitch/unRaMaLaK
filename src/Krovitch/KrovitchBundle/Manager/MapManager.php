<?php

namespace Krovitch\KrovitchBundle\Manager;

use Krovitch\BaseBundle\Manager\BaseManager;
use Krovitch\KrovitchBundle\Entity\Map;
use Krovitch\KrovitchBundle\Utils\MapDataJson;
use Krovitch\KrovitchBundle\Utils\MapDataXml;
use Krovitch\KrovitchBundle\Utils\Path;
use Krovitch\KrovitchBundle\Utils\Resources;

/**
 * Class MapManager
 * @package Krovitch\KrovitchBundle\Manager
 */
class MapManager extends BaseManager
{
    /**
     * Map data
     * @var
     */
    protected $data = array();

    /**
     * Save map into database, also save its data into xml file
     * @param Map $map
     */
    public function save($map)
    {
        // save map in db
        parent::save($map);
        // map data are stored in a xml file
        $mapDataXml = new MapDataXml($map, Path::getAbsoluteXmlPath());

        if ($this->data || !$map->getDatafile()) {
            $filename = $mapDataXml->save($this->data);
            // save map xml file
            $map->setDatafile($filename);
            parent::save($map);
        }
    }

    /**
     * Create a json object containing data for map
     */
    public function load(Map $map)
    {
        // read xml data
        $mapDataXml = new MapDataXml($map);
        $data = $mapDataXml->load();
        // converts data into json
        $mapDataJson = new MapDataJson($data);
        return $mapDataJson->load();
    }

    public function loadTextures()
    {
        $resources = new Resources();

        return json_encode($resources->getTextures());
    }

    public function setData($data)
    {
        $this->data = $data;
    }
}