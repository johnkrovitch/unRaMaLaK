<?php

namespace Gmf\GmfBundle\Tests\Core;

use Gmf\GmfBundle\Core\GameApplication;
use Gmf\GmfBundle\Core\GameCore;
use Gmf\GmfBundle\Core\GameEngine;

class GameCoreTests extends \PHPUnit_Framework_TestCase
{
    /**
     * Engine should run games cores
     */
    public function testRun()
    {
        $core = new GameCore();
        $bricks = $core->getBricks();

        $this->assertTrue(count($bricks) > 0, 'GameCore failed to create game bricks !');
    }
}