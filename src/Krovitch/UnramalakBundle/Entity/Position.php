<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Behavior\Positionable;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\PositionRepository")
 * @ORM\Table(name="position")
 */
class Position extends Entity
{
    use Positionable;

    public function __construct($x = 0, $y = 0)
    {
        $this->x = 0;
        $this->y = 0;
    }
} 