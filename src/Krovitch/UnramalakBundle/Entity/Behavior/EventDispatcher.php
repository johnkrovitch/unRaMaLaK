<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;


trait EventDispatcher
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Return the EventDispatcher
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
} 