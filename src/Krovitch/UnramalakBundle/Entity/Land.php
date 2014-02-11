<?php


namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Behavior\Nameable;
use Krovitch\UnramalakBundle\Entity\Behavior\Typeable;

/**
 * Land
 *
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\LandRepository")
 * @ORM\Table(name="land")
 */
class Land extends Entity
{
    use Nameable, Typeable;

    /**
     * Land medias. A land can have a or more medias
     *
     * @ORM\ManyToOne(targetEntity="Media")
     */
    protected $medias;
} 