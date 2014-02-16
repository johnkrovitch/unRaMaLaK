<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Behavior\Positionable;

/**
 * Cell
 *
 * Represent map cells
 *
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\CellRepository")
 * @ORM\Table(name="cell")
 */
class Cell extends Entity
{
    use Positionable;

    /**
     * Cell land type
     *
     * @ORM\ManyToOne(targetEntity="Land")
     */
    protected $land;

    /**
     * Map which cell belongs
     *
     * @ORM\ManyToOne(targetEntity="Map")
     */
    protected $map;

    /**
     * Return cell land type
     *
     * @return Land
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * Set cell land type
     *
     * @param Land $land
     */
    public function setLand($land)
    {
        $this->land = $land;
    }

    /**
     * Return map which the cell belongs
     *
     * @return mixed
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set cell map
     *
     * @param mixed $map
     */
    public function setMap($map)
    {
        $this->map = $map;
    }
}