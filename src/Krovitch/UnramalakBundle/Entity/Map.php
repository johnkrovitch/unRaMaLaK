<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Behavior\Descriptionable;
use Krovitch\UnramalakBundle\Entity\Behavior\Nameable;
use Krovitch\UnramalakBundle\Utils\Path;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\MapRepository")
 * @ORM\Table(name="map")
 */
class Map extends Entity
{
    use Nameable, Descriptionable;

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

    /**
     * Map cells
     *
     * @ORM\OneToMany(targetEntity="Cell", mappedBy="map")
     */
    protected $cells;

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
        $path = new Path();

        if ($absolute && $datafile) {
            $datafile = $path->getXmlPath() . DIRECTORY_SEPARATOR . $datafile;
        }
        return $datafile;
    }

    public function setDatafile($datafile)
    {
        $this->datafile = $datafile;
    }
}