<?php

namespace Gmf\GmfBundle\Brick\View;

use Gmf\GmfBundle\Brick\GameBrick;

class ViewBrick extends GameBrick
{
    public function render()
    {
        return '<div>This a brick renders !!!!</div>';
    }
}