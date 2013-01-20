<?php

namespace Krovitch\KrovitchBundle\Tests\Entity;

use Krovitch\KrovitchBundle\Entity\Hero;

class HeroTest extends \PHPUnit_Framework_TestCase
{
    public function testHero()
    {
        $hero = new Hero();
        $this->assertTrue(true);
    }
}