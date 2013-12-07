<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;

use Krovitch\UnramalakBundle\Constants\Event as Constant;
use Krovitch\UnramalakBundle\Entity\UnramalakEvent;

/**
 * Living
 *
 * Represents living units. They have life points
 */
trait Living
{
    /**
     * Return event dispatcher
     *
     * @return EventDispatcher
     */
    abstract function getEventDispatcher();

    /**
     * @ORM\Column(type="integer")
     */
    protected $life;

    /**
     * @return mixed
     */
    public function getLife()
    {
        return $this->life;
    }

    /**
     * @param mixed $life
     */
    public function setLife($life)
    {
        $this->life = $life;
    }

    public function takeDamage($damagePoints)
    {
        $this->life = (int)$this->life - (int)$damagePoints;

        if ($this->life <= 0) {
            $event = new UnramalakEvent();
            $event->setData($this);
            $this->getEventDispatcher()->dispatch(Constant::UNIT_KILLED, $event);
        }
    }
} 