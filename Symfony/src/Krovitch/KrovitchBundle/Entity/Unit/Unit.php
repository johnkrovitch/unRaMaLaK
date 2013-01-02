<?php

namespace Krovitch\KrovitchBundle\Entity\Unit;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\KrovitchBundle\Entity\Entity;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 * @ORM\Entity(repositoryClass="Krovitch\KrovitchBundle\Repository\UnitRepository")
 * @ORM\Table(name="unit")
 * @ORM\InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"unit" = "Unit", "hero" = "Hero"})
 */
class Unit extends Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @ORM\Column(type="integer")
     */
    protected $life;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Unit
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Unit
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set life
     *
     * @param integer $life
     * @return Unit
     */
    public function setLife($life)
    {
        $this->life = $life;
    
        return $this;
    }

    /**
     * Get life
     *
     * @return integer 
     */
    public function getLife()
    {
        return $this->life;
    }
}