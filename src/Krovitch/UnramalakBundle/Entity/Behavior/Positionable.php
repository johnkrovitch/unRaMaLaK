<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;

/**
 * Positionable
 *
 * Capacity to have a position (x and y coordinates)
 */
trait Positionable
{
    /**
     * X entity position
     *
     * @ORM\Column(name="x", type="integer")
     */
    protected $x;

    /**
     * Y entity position
     *
     * @ORM\Column(name="y", type="integer")
     */
    protected $y;

    /**
     * Return x coordinates
     *
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set x coordinates
     *
     * @param integer $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * Get y coordinates
     *
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set y coordinates
     *
     * @param integer $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }
} 