<?php

namespace Krovitch\UnramalakBundle\Utils\Json;

class MapJson
{
    protected $data;
    protected $textures;

    public function __construct(array $data, array $textures = null)
    {
        $this->data = $data;
        $this->textures = $textures;
    }

    public function load()
    {
        $data = array('mapData' => $this->data, 'textures' => $this->textures);
        $json = json_encode($data, JSON_PRETTY_PRINT);

        return $json;
    }
}