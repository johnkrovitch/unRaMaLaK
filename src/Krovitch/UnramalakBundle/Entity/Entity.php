<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Entity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}