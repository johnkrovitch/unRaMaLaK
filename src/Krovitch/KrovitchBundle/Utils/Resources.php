<?php


namespace Krovitch\KrovitchBundle\Utils;


use Symfony\Component\Finder\Finder;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class Resources
 * Manage map resources like textures, sound....
 * @package Krovitch\KrovitchBundle\Utils
 */
class Resources
{
    public $texturesBundlePath = '/src/Krovitch/KrovitchBundle/Resources/public/img/textures/';
    public $texturesWebPath = '/bundles/krovitch/img/textures/';
    public $allowedTextures = ['sand', 'water', 'plains'];


    /**
     * Return map required textures
     * @return array
     * @throws \Symfony\Component\Security\Acl\Exception\Exception
     */
    public function getTextures()
    {
        $textures = array();
        $finder = new Finder();
        $finder->files()->in(Path::getApplicationPath() . $this->texturesBundlePath)->exclude('test');

        foreach ($finder as $path) {
            $explodedPath = explode('/', $path);
            // get parent directory
            $count = count($explodedPath);
            $textureType = $explodedPath[$count - 2];

            if (!in_array($textureType, $this->allowedTextures)) {
                throw new Exception('Textures type not allowed : ' . $textureType);
            }
            // TODO improves with building and other textures stuff...
            $texturesKey = 'land_' . $textureType;

            if (!array_key_exists($texturesKey, $textures)) {
                $textures[$texturesKey] = array();
            }
            $textures[$texturesKey] = $this->getPublicPathForTexture($textureType, $explodedPath[$count - 1]);
        }
        return $textures;
    }

    private function getPublicPathForTexture($textureType, $texture)
    {
        return $this->texturesWebPath . $textureType . '/' . $texture;
    }
}