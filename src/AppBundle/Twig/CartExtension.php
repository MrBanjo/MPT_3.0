<?php

namespace AppBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class CartExtension extends \Twig_Extension
{
    /**
     * @var Doctrine
     */
    private $doctrine;
    private $session;

    /**
     * @param Doctrine $doctrine
     */
    public function __construct(EntityManager $doctrine, Session $session)
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('showCountCart', array($this, 'countCart')),
        );
    }

    public function countCart($user)
    {
        $results = $this->doctrine
        ->createQuery('SELECT c FROM AppBundle:Caddie c WHERE (c.user = :name1 OR c.identifiant = :name2)')
        ->setParameter('name1', $user)
        ->setParameter('name2', $this->session->getId())
        ->getResult();

        return count($results);
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'cart';
    }
}
