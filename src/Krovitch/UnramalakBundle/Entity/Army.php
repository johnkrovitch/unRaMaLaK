<?php


namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Army
 *
 * An army represents several units owned by an player *
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\ArmyRepository")
 * @ORM\Table(name="army")
 */
class Army extends Entity
{
    /**
     * Name of the unit
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * Unit composing this army
     *
     * @ORM\OneToMany(targetEntity="Unit", mappedBy="army")
     */
    protected $units;

    /**
     * User who owned this army
     *
     * @ORM\ManyToOne(targetEntity="Krovitch\KrovitchUserBundle\Entity\User", inversedBy="armies")
     */
    protected $user;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param mixed $units
     */
    public function setUnits($units)
    {
        $this->units = $units;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
} 