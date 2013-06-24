<?php

namespace Krovitch\KrovitchBundle\Utils;

/**
 * Class Path
 * Application path reference
 * @package Krovitch\KrovitchBundle\Utils
 */
class Path
{
    protected $xmlPath = '/src/Krovitch/KrovitchBundle/Resources/maps/';

    public function getXmlPath($absolute = true)
    {
        $path = $this->xmlPath;

        if ($absolute) {
            $path = $this->getApplicationPath().$path;
        }
        return $path;
    }

    public function getApplicationPath()
    {
        return realpath(__DIR__ . '/../../../..');
    }
}