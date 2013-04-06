<?php

namespace Krovitch\KrovitchBundle\Manager;

use \Krovitch\KrovitchBundle\Entity\Map;

class MapManager extends BaseManager
{
    public function saveMapData(Map $map)
    {
        $dom = new \DOMDocument();
        $pattern = ('map-%s-%s');
        $datafileName = $this->getMapDataFilePath().sprintf($pattern, $map->getId(), $map->getName());
        // if map is new, we must create its xml file
        if (is_file($datafileName)) {
            $dom->load($datafileName);
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

        while ($x < $map->getHeight()) {
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
        // save xml file
        $dom->save($map);
    }

    /**
     * Create a json object containing data for map
     */
    public function createJsonData(Map $map)
    {
        // get map data json template file
        $template = file_get_contents($this->getMapDataTemplatePath().'mapData.template.json');
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
        return __DIR__ . '/Resources/maps/';
    }

    public function getMapDataTemplatePath()
    {
        return __DIR__ . '/Resources/templates/';
    }
}