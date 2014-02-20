<?php


namespace Krovitch\UnramalakBundle\Behavior;

use Krovitch\UnramalakBundle\Manager\LandManager;

trait LandManagerContainer
{
    /**
     * The land manager
     *
     * @var LandManager
     */
    protected $landManager;

    /**
     * Set land manager
     *
     * @param LandManager $landManager
     */
    public function setLandManager(LandManager $landManager)
    {
        $this->landManager = $landManager;
    }

    /**
     * Return land manager
     *
     * @return LandManager
     */
    protected function getLandManager()
    {
        return $this->landManager;
    }
} 