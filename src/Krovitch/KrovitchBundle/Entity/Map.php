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
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\Column(type="string")
     */
    protected $datafile;

    protected $cells;


    public function load()
    {
        if ($this->cells) {
            // TODO load cells, ie create objects collection
        }
    }

    /**
     * Get id
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set content
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

    public function getDatafile()
    {
        return $this->getDatafile();
    }

    public function setDatafile($datafile)
    {
        $this->datafile = $datafile;
    }

    /**
     * Serialize this map into a json string understandable for js map object
     */
    public function serialize()
    {
        $mapJson = new \stdClass();
        $mapJson->id = $this->id;
        $mapJson->name = $this->name;
        $mapJson->height = $this->height;
        $mapJson->width = $this->width;
        $mapJson->cells = $this->getContent();

        die(var_dump($mapJson));

        return json_encode($mapJson);
    }
}