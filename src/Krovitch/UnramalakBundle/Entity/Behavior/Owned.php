<?php


namespace Krovitch\UnramalakBundle\Entity\Behavior;

use FOS\UserBundle\Model\UserInterface;

class Owned
{
    /**
     * @ORM\ManyToOne
     * @var UserInterface
     */
    protected $user;
} 