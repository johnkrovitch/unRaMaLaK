<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;


trait Descriptionable
{
    /**
     * Entity description
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $description;

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
} 