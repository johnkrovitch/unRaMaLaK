<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Behavior\Descriptionable;
use Krovitch\UnramalakBundle\Entity\Behavior\Nameable;
use Krovitch\UnramalakBundle\Entity\Behavior\Sizable;
use Krovitch\UnramalakBundle\Utils\Path;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\MapRepository")
 * @ORM\Table(name="map")
 */
class Map extends Entity
{
    use Nameable, Descriptionable, Sizable;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $datafile;

    /**
     * Map cells
     *
     * @ORM\OneToMany(targetEntity="Cell", mappedBy="map", cascade={"remove", "persist"})
     * @var ArrayCollection
     */
    protected $cells;

    /**
     * Padding between each cell
     *
     * @ORM\Column(name="cell_padding", type="integer")
     */
    protected $cellPadding;

    /**
     * Number of cell sides (by default, hexagons)
     *
     * @ORM\Column(name="number_of_sides", type="integer", options={"default": 5})
     */
    protected $numberOfSides;

    /**
     * Starting point in canvas for map
     *
     * @ORM\ManyToOne(targetEntity="Position", cascade={"remove", "persist"})
     */
    protected $startingPoint;

    /**
     * Cell shape radius (by default, 50)
     *
     * @ORM\Column(type="integer", options={"default": 50})
     */
    protected $radius;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getDatafile($absolute = true)
    {
        $datafile = $this->datafile;
        $path = new Path();

        if ($absolute && $datafile) {
            $datafile = $path->getXmlPath() . DIRECTORY_SEPARATOR . $datafile;
        }
        return $datafile;
    }

    public function setDatafile($datafile)
    {
        $this->datafile = $datafile;
    }

    public function getCellPadding()
    {
        return $this->cellPadding;
    }

    public function setCellPadding($cellPadding)
    {
        $this->cellPadding = $cellPadding;
    }

    public function getNumberOfSides()
    {
        return $this->numberOfSides;
    }

    public function setNumberOfSides($numberOfSides)
    {
        $this->numberOfSides = $numberOfSides;
    }

    /**
     * @return Position
     */
    public function getStartingPoint()
    {
        return $this->startingPoint;
    }

    /**
     * @param mixed $startingPoint
     */
    public function setStartingPoint($startingPoint)
    {
        $this->startingPoint = $startingPoint;
    }

    /**
     * @return mixed
     */
    public function getRadius()
    {
        return $this->radius;
    }

    /**
     * @param mixed $radius
     */
    public function setRadius($radius)
    {
        $this->radius = $radius;
    }

    /**
     * @return mixed
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param mixed $cells
     */
    public function setCells($cells)
    {
        $this->cells = $cells;
    }

    public function addCell(Cell $cell)
    {
        $this->cells->add($cell);
    }

    public function removeCell(Cell $cell)
    {
        $this->cells->remove($cell);
    }

    public function removeCells()
    {
        $this->cells->clear();
    }
}