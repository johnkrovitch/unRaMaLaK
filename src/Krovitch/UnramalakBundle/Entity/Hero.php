<?php

namespace Krovitch\UnramalakBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\UnramalakBundle\Entity\Entity;

/**
 * @ORM\Entity(repositoryClass="Krovitch\UnramalakBundle\Repository\HeroRepository")
 * @ORM\Table(name="hero")
 */
class Hero extends Unit
{
}