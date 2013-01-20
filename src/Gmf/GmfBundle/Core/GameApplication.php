<?php

namespace Gmf\GmfBundle\Core;

class GameApplication
{
    protected $engines = array();

    /**
     * Initialize games engines
     */
    public function __construct()
    {
        $this->engines[] = new GameEngine();
    }

    /**
     * Returns current applications engines
     * @return GameEngine[]
     */
    public function getEngines()
    {
        return $this->engines;
    }
}