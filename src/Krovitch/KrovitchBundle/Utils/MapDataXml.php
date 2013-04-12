<?php

namespace Krovitch\KrovitchBundle\Utils;

use Krovitch\KrovitchBundle\Entity\Map;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * Class MapDataXml
 * Interface between php and xml. Unramalak maps store its data (cells, events...) in a xml file
 * @package Krovitch\KrovitchBundle\Utils
 */
class MapDataXml
{
    protected $map;
    protected $document;
    protected $dataFilePath;

    /**
     * Return a MapDataXml for a map
     * @param Map $map
     * @param $dataFilePath
     */
    public function __construct(Map $map, $dataFilePath)
    {
        $this->map = $map;
        $this->dataFilePath = $dataFilePath;
        // init dom document
        $this->document = new \DOMDocument();
        // keep indention indentation
        $this->document->preserveWhiteSpace = false;
        $this->document->formatOutput = true;
    }

    /**
     * Create or update xml file with map data
     */
    public function save()
    {
        $datafile = $this->map->getDatafile();

        // if map is new, we must create its xml file
        if (!$datafile) {
            $this->createMapData();
        }
        else {
            // if map isn't new and data file is not valid, it is not normal
            if (!is_file($datafile)) {
                throw new FileNotFoundException($datafile);
            }
            // map has a valid file, we should update data
        }

    }

    /**
     * Generate Map data file path according to the name pattern and map id
     * @param $id
     * @return string
     */
    protected function generateDataFile($id)
    {
        $pattern = ('map-%s-%s.xml');
        return $this->dataFilePath . sprintf($pattern, $id, 'name');
    }

    /**
     * Converts php data into xml data
     * xml template :
     * <map>
     *  <profile>...</profile>
     *  <cells>...</cells>
     *  <events>...</events>
     * </map>
     */
    public function createMapData()
    {
        // create map profile node (name, size...)
        $profile = $this->document->createElement('profile');
        $profile->appendChild($this->document->createElement('id', 0));
        $profile->appendChild($this->document->createElement('name', $this->map->getName()));
        $profile->appendChild($this->document->createElement('width', $this->map->getWidth()));
        $profile->appendChild($this->document->createElement('height', $this->map->getHeight()));
        // create cells nodes
        $cells = $this->document->createElement('cells');
        // for now, map is square-like (same number of cells in each row)
        $x = 0;
        // build dom elements for each cell
        while ($x < $this->map->getHeight()) {
            $y = 0;
            while ($y < $this->map->getWidth()) {
                // create cell node: coordinates and type
                $cell = $this->document->createElement('cell');
                $cell->setAttribute('x', $x);
                $cell->setAttribute('y', $y);
                $cell->setAttribute('type', '');
                $cells->appendChild($cell);
                $y++;
            }
            $x++;
        }
        // create top nodes
        $mapRoot = $this->document->createElement('map');
        $mapRoot->appendChild($profile);
        $mapRoot->appendChild($cells);
        $this->document->appendChild($mapRoot);
        // save xml file
        $this->document->save($this->generateDataFile($this->map->getId()));
    }
}