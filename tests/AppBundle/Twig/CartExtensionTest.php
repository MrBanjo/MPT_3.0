<?php

namespace Tests\AppBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class CartExtensionTest extends WebTestCase
{
    public function testCountCart()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $_em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $_session = new Session(new MockFileSessionStorage());
        $_security = $kernel->getContainer()->get('security.token_storage');

        $results = $_em
        ->createQuery('SELECT c FROM AppBundle:Caddie c WHERE (c.user = :name1 OR c.session = :name2)')
        ->setParameter('name1', '66')
        ->setParameter('name2', $_session->getId())
        ->getOneOrNullResult();

        /*$this->assertInternalType("int", $results);*/
    }
}
