<?php


namespace Krovitch\UnramalakBundle\Behavior;

use Krovitch\UnramalakBundle\Manager\MapManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait HasMapManager
{
    /**
     * @param $id
     * @return ContainerInterface
     */
    abstract function get($id);

    /**
     * Return map manager
     *
     * @return MapManager
     */
    protected function getMapManager()
    {
        return $this->get('unramalak.manager.map');
    }
} 