<?php

namespace Krovitch\KrovitchBundle\Utils;

/**
 * Class Path
 * Application path reference
 * @package Krovitch\KrovitchBundle\Utils
 */
class Path
{
    static function getRelativeXmlPath()
    {
        return '/src/Krovitch/KrovitchBundle/Resources/maps/';
    }

    static function getAbsoluteXmlPath()
    {
        return self::getApplicationPath() . self::getRelativeXmlPath();
    }

    static function getApplicationPath()
    {
        return realpath(__DIR__ . '/../../../..');
    }
}