<?php

namespace Gmf\GmfBundle\Core;

class GameEngine
{
    protected $cores = array();

    public function __construct()
    {
        $this->cores[] = new GameCore();
    }

    /**
     * Return engine's gamecore
     * @return GameCore[]
     */
    public function getCores()
    {
        return $this->cores;
    }
}