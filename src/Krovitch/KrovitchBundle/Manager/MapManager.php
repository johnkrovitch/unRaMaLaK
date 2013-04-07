<?php

namespace Krovitch\KrovitchBundle\Manager;

use \Krovitch\KrovitchBundle\Entity\Map;

class MapManager extends BaseManager
{
    public function saveMapData(Map $map)
    {
        $dom = new \DOMDocument();
        // indentation
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $pattern = ('map-%s-%s.xml');
        $datafile = $this->getMapDataFilePath() . sprintf($pattern, $map->getId(), 'name');
        // if map is new, we must create its xml file
        if (is_file($datafile)) {
            //$dom->load($datafile);

            //die;
        }
        // no, so we should create it
        else {
            touch($datafile);
        }
        // create map profile node (name, size...)
        $profile = $dom->createElement('profile');
        $profile->appendChild($dom->createElement('id', 0));
        $profile->appendChild($dom->createElement('name', $map->getName()));
        $profile->appendChild($dom->createElement('width', $map->getWidth()));
        $profile->appendChild($dom->createElement('height', $map->getHeight()));
        // create cells nodes
        $cells = $dom->createElement('cells');
        // for now, map is square-like (same number of cells in each row)
        $x = 0;
        $y = 0;
        // build dom elements for each cell
        while ($x < $map->getHeight()) {
            $y = 0;
            while ($y < $map->getWidth()) {
                // create cell node: coordinates and type
                $cell = $dom->createElement('cell');
                $cell->setAttribute('x', $x);
                $cell->setAttribute('y', $y);
                $cell->setAttribute('type', '');
                $cells->appendChild($cell);
                $y++;
            }
            $x++;
        }
        // create top nodes
        $mapRoot = $dom->createElement('map');
        $mapRoot->appendChild($profile);
        $mapRoot->appendChild($cells);
        $dom->appendChild($mapRoot);
        // save xml file
        $dom->save($datafile);
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