<?php

namespace Krovitch\UnramalakBundle\Entity\Behavior;

use Krovitch\UnramalakBundle\Constants\Event;

/**
 * Levelable
 *
 * Ability to gain experience and levels
 */
trait Levelable
{
    /**
     * Current level
     *
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * Current experience
     *
     * @ORM\Column(type="integer")
     */
    protected $experience;

    /**
     * Next level experience cap
     *
     * @ORM\Column(type="integer")
     */
    protected $experienceCap;

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param mixed $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    }

    public function addExperience($xp)
    {
        $this->experience = (int)$this->experience + (int)$xp;

        if ($this->experience >= $this->experienceCap) {
            $this->getEventDispatcher()->dispatch(Event::UNIT_LEVEL_UP);
        }
    }

    /**
     * @return mixed
     */
    public function getExperienceCap()
    {
        return $this->experienceCap;
    }

    /**
     * @param mixed $experienceCap
     */
    public function setExperienceCap($experienceCap)
    {
        $this->experienceCap = $experienceCap;
    }
} 