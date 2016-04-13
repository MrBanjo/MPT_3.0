<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenusControllerTest extends WebTestCase
{
    public function testshowCurrentMenu()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $crawler = $client->request('GET', '/menus');

        $profile = $client->getProfile();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('.bxslider')->count() == 2);
    }
}
