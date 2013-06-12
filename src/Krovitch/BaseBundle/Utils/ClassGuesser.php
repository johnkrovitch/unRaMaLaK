<?php

namespace Krovitch\BaseBundle\Utils;


use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ClassGuesser
 * Find some info from a class full path
 * @package Krovitch\BaseBundle\Utils
 */
class ClassGuesser
{
    protected $namespace;
    protected $bundle;
    protected $directory;
    protected $class;

    protected $classPattern = '/([a-z]*)\\\\([a-z]*)\\\\([a-z]*)\\\\([a-z]*)/i';


    public function __construct($mixed)
    {
        if (!$mixed) {
            throw new Exception('Unable to guess class on an empty object.');
        }
        $matches = array();
        $className = is_object($mixed) ? get_class($mixed) : $mixed;
        preg_match($this->classPattern, $className, $matches);

        $this->namespace = $matches[1];
        $this->bundle = $matches[2];
        $this->directory = $matches[3];
        $this->class = $matches[4];
    }

    /**
     * Return class namespace
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Return class bundle name
     * @return string
     */
    public function getBundle()
    {
        return $this->bundle;
    }

    /**
     * Return class parent directory name
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Return class name
     * @param array $excludes
     * @return string
     */
    public function getClass($excludes = array())
    {
        $class = $this->class;

        if (count($excludes)) {
            $class = str_replace($excludes, '', $class);
        }
        return $class;
    }
}