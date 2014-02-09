<?php

namespace Krovitch\UnramalakBundle\Manager;

use GeorgetteParty\BaseBundle\Manager\BaseManager;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Utils\Json\MapJson;
use Krovitch\UnramalakBundle\Utils\Path;
use Krovitch\UnramalakBundle\Utils\Resources;
use Krovitch\UnramalakBundle\Utils\TransformerInterface;
use Krovitch\UnramalakBundle\Utils\Xml\MapXml;

/**
 * Class MapManager
 * @package Krovitch\UnramalakBundle\Manager
 */
class MapManager extends BaseManager
{
    protected $mapFilePath = '';

    /**
     * @var TransformerInterface
     */
    protected $transformer;

    /**
     * Map data
     * @var
     */
    protected $data = array();

    /**
     * Save map into database
     * @param Map $map
     * @param $data
     * @return \GeorgetteParty\BaseBundle\Manager\BaseManager|void
     */
    public function saveMap(Map $map, $data)
    {
        $this->getTransformer()->transform($data);

        //$jsonConverter = new MapJson($map, $data);
        //$jsonConverter->fromJson();
        die('ok');

//        $path = new Path();
//        // save map in db
//        parent::save($map);
//        // map data are stored in a xml file
//        $mapDataXml = new MapXml($map, $path->getXmlPath());
//
//        if ($this->data || !$map->getDatafile()) {
//            $filename = $mapDataXml->save($this->data);
//            // save map xml file
//            $map->setDatafile($filename);
//            parent::save($map, $flush);
//        }
    }

    public function findWithCells($id)
    {
        return $this->getRepository('Krovitch\UnramalakBundle\Entity\Map')->findWithCells($id);
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
        $mapDataJson = new MapJson($map, []);

        return $mapDataJson->toJson($data, $textures);
    }

    /**
     * Regenerate maps data file
     *
     * @param Map $map
     */
    public function regenerate(Map $map)
    {
        $path = new Path();
        // read xml map data
        $mapDataXml = new MapXml($map, $path->getXmlPath());
        // recreate xml file
        $dataFile = $mapDataXml->create();
        // saving new location
        $map->setDatafile($dataFile);
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
}