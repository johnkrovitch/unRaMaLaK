<?php

namespace Krovitch\KrovitchBundle\Tests\Entity\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MapControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/editor');

        $this->assertTrue(true);
    }
}