<?php


namespace Krovitch\UnramalakBundle\Utils;

use Krovitch\UnramalakBundle\Form\Interfaces\MediaInterface;

class Media implements MediaInterface
{
    protected $name;

    protected $file;

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
}