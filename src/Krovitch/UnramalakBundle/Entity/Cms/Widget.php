<?php


namespace Krovitch\UnramalakBundle\Entity\Cms;

use Krovitch\UnramalakBundle\Entity\Entity;

class Widget extends Entity
{
    /**
     * @ORM\Column
     */
    protected $name;

    protected $location;

    protected $html;
} 