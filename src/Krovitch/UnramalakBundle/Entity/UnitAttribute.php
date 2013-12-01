<?php


namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitAttribute
 * Liaison between an unit and its attributes
 *
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\UnitRepository")
 * @ORM\Table(name="unit_attribute")
 */
class UnitAttribute extends Entity
{
    /**
     * Unit of the relation
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="attributes")
     */
    protected $unit;

    /**
     * Attributes of the relation
     *
     * @ORM\ManyToOne(targetEntity="Attribute")
     */
    protected $attributes;
} 