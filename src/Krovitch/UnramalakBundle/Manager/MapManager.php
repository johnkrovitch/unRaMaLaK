<?php

namespace Krovitch\UnramalakBundle\Manager;
use GeorgetteParty\BaseBundle\Manager\BaseManager;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Utils\Json\MapJson;
use Krovitch\UnramalakBundle\Utils\Path;
use Krovitch\UnramalakBundle\Utils\Resources;
use Krovitch\UnramalakBundle\Utils\Xml\MapXml;

/**
 * Class MapManager
 * @package Krovitch\UnramalakBundle\Manager
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
     * @param bool $flush
     * @return \GeorgetteParty\BaseBundle\Manager\BaseManager|void
     */
    public function save($map, $flush = true)
    {
        $path = new Path();
        // save map in db
        parent::save($map);
        // map data are stored in a xml file
        $mapDataXml = new MapXml($map, $path->getXmlPath());

        if ($this->data || !$map->getDatafile()) {
            $filename = $mapDataXml->save($this->data);
            // save map xml file
            $map->setDatafile($filename);
            parent::save($map, $flush);
        }
    }

    /**
     * Create a json object containing data for map.
     * Json contains either map data and textures
     */
    public function load(Map $map)
    {
        // read xml map data
        $mapDataXml = new MapXml($map);
        $data = $mapDataXml->load();
        // load textures
        $textures = (new Resources())->getTextures();
        // converts data into json
        $mapDataJson = new MapJson($data, $textures);

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