<?php


namespace Krovitch\UnramalakBundle\Entity;

use Symfony\Component\EventDispatcher\Event;

class UnramalakEvent extends Event
{
    protected $data;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
} 