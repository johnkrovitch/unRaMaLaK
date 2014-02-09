<?php

namespace Krovitch\UnramalakBundle\Utils\Json;

use Krovitch\UnramalakBundle\Entity\Map;

class MapJson
{
    protected $map;
    protected $data;
    protected $textures;

    public function __construct(Map $map, $data)
    {
        $this->map = $map;
        $this->data = $data;
    }

    public function toJson(array $data = null, array $textures = null)
    {
        $this->data = $data;
        $this->textures = $textures;
        // adding textures to data
        $this->data['textures']  = $this->textures;
        $json = json_encode($this->data, JSON_PRETTY_PRINT);

        return $json;
    }

    public  function fromJson()
    {
        print_r($this->data);
        die('lol');
    }
}