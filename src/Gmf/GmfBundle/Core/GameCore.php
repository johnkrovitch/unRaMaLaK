<?php

namespace Gmf\GmfBundle\Core;

class GameCore
{
    protected $bricks = array();

    public function __construct()
    {
        $this->bricks[] = new GameBrick();
    }

    public function getBricks()
    {
        return $this->bricks;
    }
}