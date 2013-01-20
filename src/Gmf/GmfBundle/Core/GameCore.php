<?php

namespace Gmf\GmfBundle\Core;

use Gmf\GmfBundle\Brick\GameBrick;
use Gmf\GmfBundle\Brick\View\ViewBrick;
use Gmf\GmfBundle\Exception\RenderException;

class GameCore
{
    /**
     * @var GameBrick[]
     */
    protected $bricks = array();

    /**
     * @var ViewBrick[]
     */
    protected $viewBricks = array();

    public function __construct()
    {
    }

    public function render()
    {
        $render = '';

        if (!count($this->viewBricks)) {
            throw new RenderException('CoreRender failed. No ViewBrick was found');
        }
        foreach ($this->viewBricks as $brick) {
            $render .= $brick->render();
        }
        return $render;
    }

    public function addBrick(GameBrick $brick)
    {
        if ($brick instanceof ViewBrick) {
            $this->viewBricks[] = $brick;
        }
        $this->bricks[] = $brick;
    }

    public function getBricks()
    {
        return $this->bricks;
    }
}