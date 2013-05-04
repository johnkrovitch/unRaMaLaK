<?php

namespace Krovitch\KrovitchBundle\Utils;

use Krovitch\KrovitchBundle\Entity\Map;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Routing\Exception\InvalidParameterException;

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
     * @param $mapData
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     * @return string map data file path
     */
    public function save($mapData)
    {
        $datafile = $this->map->getDatafile();

        // if map is new, we must create its xml file
        if (!$datafile) {
            return $this->create();
        }
        else if (!count($mapData)) {
            throw new InvalidParameterException('Trying to save empty data');
        }
        // here map should have a valid data file
        $this->checkFile($datafile);
        // map has a valid file, we should update data
        $xml = simplexml_load_file($datafile);
        $cells = array();
        // decode data from json
        $index = 0;

        foreach ($mapData->cells as $cell) {
            foreach ($xml->cells->cell as $xmlCell) {

                if ($xmlCell['x'] == $cell->x && $xmlCell['y'] == $cell->y) {
                    $xmlCell['type'] = $cell->type;
                }
                $index++;
            }
        }
        $xml->asXML($datafile);

        return $datafile;
    }

    public function load()
    {
        // load and check file
        $datafile = $this->map->getDatafile();
        $this->checkFile($datafile);
        // load xml file
        $xml = simplexml_load_file($datafile);
        $mapData = array('profile' => array(), 'cells' => array(), 'events' => array());
        // load profile
        $mapData['profile']['id'] = (int)$xml->profile->id;
        $mapData['profile']['name'] = (string)$xml->profile->name;
        $mapData['profile']['width'] = (int)$xml->profile->width;
        $mapData['profile']['height'] = (int)$xml->profile->height;
        // load cells
        foreach ($xml->cells->cell as $cell) {
            $cellData = array(
                'x' => (string)$cell['x'],
                'y' => (string)$cell['y'],
                'type' => (string)$cell['type']
            );
            $mapData['cells'][] = $cellData;
        }
        return $mapData;
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

    protected function checkFile($file)
    {
        if (!is_file($file)) {
            throw new FileNotFoundException($file);
        }
        if (!is_readable($file)) {
            throw new AccessDeniedException($file);
        }
    }

    protected function checkData()
    {
        $profile = $this->document->getElementsByTagName('profile');
        $cells = $this->document->getElementsByTagName('cells');
        $events = $this->document->getElementsByTagName('events');

        if (!$profile->length || !$cells->length || !$events->length) {
            throw new Exception('Xml data file has no valid roots. It should have profile, cells and events root nodes.');
        }
        // TODO make better check of data
    }

    /**
     * Create xml data file
     * xml template :
     * <map>
     *  <profile>...</profile>
     *  <cells>...</cells>
     *  <events>...</events>
     * </map>
     * @return string datafile path
     */
    public function create()
    {
        // create map profile node (name, size...)
        $profile = $this->document->createElement('profile');
        $profile->appendChild($this->document->createElement('id', $this->map->getId()));
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
        // events
        $events = $this->document->createElement('events');
        // create top nodes
        $mapRoot = $this->document->createElement('map');
        $mapRoot->appendChild($profile);
        $mapRoot->appendChild($cells);
        $mapRoot->appendChild($events);
        // save nodes into document
        $this->document->appendChild($mapRoot);
        // save xml file
        $datafile = $this->generateDataFile($this->map->getId());
        $this->document->save($datafile);

        return $datafile;
    }
}