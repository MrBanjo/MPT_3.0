<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->enableProfiler();

        $crawler = $client->request('GET', '/');

        $profile = $client->getProfile();
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('.blog_accueil_box')->count() <= 3);
    }
}
