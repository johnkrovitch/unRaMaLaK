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
        // adding textures to data
        $this->data['textures']  = $this->textures;
        $json = json_encode($this->data, JSON_PRETTY_PRINT);

        return $json;
    }
}