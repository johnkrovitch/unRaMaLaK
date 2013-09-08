<?php

namespace Krovitch\UnramalakBundle\Utils;

/**
 * Class Path
 * Application path reference
 * @package Krovitch\UnramalakBundle\Utils
 */
class Path
{
    protected $xmlPath = '/src/Krovitch/UnramalakBundle/Resources/maps/';

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