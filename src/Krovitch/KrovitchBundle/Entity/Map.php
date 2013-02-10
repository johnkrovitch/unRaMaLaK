<?php

namespace Krovitch\KrovitchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\KrovitchBundle\Entity\Entity;

/**
 * @ORM\Entity(repositoryClass="Krovitch\KrovitchBundle\Repository\MapRepository")
 * @ORM\Table(name="map")
 */
class Map extends Entity
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="integer")
     */
    protected $width;

    /**
     * @ORM\Column(type="integer")
     */
    protected $height;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Map
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
     * Set description
     *
     * @param string $description
     * @return Map
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Map
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getSize()
    {
        return $this->height . ' ' . $this->width;
    }

    /**
     * Serialize this map into a json string
     */
    public function serialize()
    {
        $mapJson = new \stdClass();
        $mapJson->id = $this->id;
        $mapJson->name = $this->name;
        $mapJson->height = $this->height;
        $mapJson->width = $this->width;
        $mapJson->cells = $this->getContent();

        return $mapJson;
    }
}