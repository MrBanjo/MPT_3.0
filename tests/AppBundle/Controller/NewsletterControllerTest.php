<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewsletterControllerTest extends WebTestCase
{
    public function testNews()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newsletter');

        $client->request(
            'POST',
            '/newsletter',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"newsletter[email]":"bncjabvno@free.fr"}'
        );

/*        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );*/
    }
}
