<?php

namespace Krovitch\KrovitchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Krovitch\KrovitchBundle\Entity\Entity;

/**
 * @ORM\Entity(repositoryClass="Krovitch\KrovitchBundle\Repository\HeroRepository")
 * @ORM\Table(name="hero")
 */
class Hero extends Unit
{
}