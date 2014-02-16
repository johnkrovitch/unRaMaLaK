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
     * Return an array with land type reference in key and land type label in value
     *
     * @return array
     */
    static function getLandTypes()
    {
        return [
            'sand' => 'unramalak.land.sand',
            'water' => 'unramalak.land.water',
            'plains' => 'unramalak.land.plains',
            'mountains' => 'unramalak.land.mountains'
        ];
    }

    /**
     * Land medias. A land can have a or more medias
     *
     * @ORM\ManyToOne(targetEntity="Media")
     */
    protected $medias;

    /**
     * @return mixed
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param mixed $medias
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
    }
} 