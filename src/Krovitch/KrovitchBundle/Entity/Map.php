<?php

namespace Krovitch\KrovitchBundle\Entity;

use Krovitch\BaseBundle\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
use Krovitch\KrovitchBundle\Utils\Path;

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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $datafile;

    protected $cells;

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

    public function getDatafile($absolute = true)
    {
        $datafile = $this->datafile;

        if ($absolute && $datafile) {
            $datafile = Path::getApplicationPath() . $datafile;
        }
        return $datafile;
    }

    public function setDatafile($datafile)
    {
        $this->datafile = $datafile;
    }
}