<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;

/**
 * Nameable
 *
 * Capacity to have a type
 */
trait Typeable
{
    /**
     * Entity type
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * Return entity type
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set entity type
     *
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
} 