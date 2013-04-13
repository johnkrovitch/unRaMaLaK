<?php

namespace Krovitch\KrovitchBundle\Utils;

class MapDataJson
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function load()
    {
        $json = json_encode($this->data, JSON_PRETTY_PRINT);

        return $json;
    }
}