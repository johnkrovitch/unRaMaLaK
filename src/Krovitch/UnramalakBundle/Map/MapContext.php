<?php


namespace Krovitch\UnramalakBundle\Map;

/**
 * MapContext
 *
 * Map data container. A context should allow map to restart at a instant t
 */
class MapContext
{
    public $cellPadding;
    /**
     * Array of cells
     *
     * [ {x: 0, y:0, type: default}, {...}]
     *
     * @var array
     */
    public $cells;
    public $numberOfSides;
    public $menuContainer;
    public $preventBubbling;
    public $profile;
    public $radius;
    public $startingPoint;

    public function __construct()
    {
        $this->cellPadding = 0;
        $this->cells = [];
        $this->numberOfSides = 6;
        $this->menuContainer = '#editor-menu';
        $this->preventBubbling = true;
        $this->radius = 50;
    }
}