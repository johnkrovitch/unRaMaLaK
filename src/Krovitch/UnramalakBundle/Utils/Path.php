<?php

namespace Krovitch\UnramalakBundle\Utils;

/**
 * Class Path
 * Application path reference
 * @package Krovitch\UnramalakBundle\Utils
 */
class Path
{
    //protected

    protected $xmlPath = '/src/Krovitch/UnramalakBundle/Resources/maps/';

    public function getXmlPath($absolute = true)
    {
        $path = $this->xmlPath;

        if ($absolute) {
            $path = $this->getApplicationPath().$path;
        }
        return $path;
    }

    static function getApplicationPath()
    {
        return realpath(__DIR__ . '/../../../..');
    }
}