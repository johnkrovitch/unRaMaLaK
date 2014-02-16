<?php

namespace Krovitch\UnramalakBundle\Manager;

use GeorgetteParty\BaseBundle\Manager\BaseManager;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Repository\MapRepository;
use Krovitch\UnramalakBundle\Utils\Json\MapJson;
use Krovitch\UnramalakBundle\Utils\Path;
use Krovitch\UnramalakBundle\Utils\Resources;
use Krovitch\UnramalakBundle\Interfaces\TransformerInterface;
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
     * Save map into database
     *
     * @param $data
     */
    public function saveMap($data)
    {
        $this->getTransformer()->transform($data);
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
    public function load($mapId)
    {
        $map = $this->findMap($mapId);

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