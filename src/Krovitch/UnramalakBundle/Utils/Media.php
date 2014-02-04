<?php


namespace Krovitch\UnramalakBundle\Utils;

use Krovitch\UnramalakBundle\Form\Interfaces\MediaInterface;

class Media implements MediaInterface
{
    protected $name;

    protected $file;

    protected $description;

    public function getName()
    {
        return $this->name;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Return media description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set media description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}