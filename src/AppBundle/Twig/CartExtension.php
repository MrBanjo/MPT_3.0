<?php

namespace AppBundle\Twig;

use Doctrine\ORM\EntityManager;

class CartExtension extends \Twig_Extension
{
    /**
     * @var Doctrine
     */
    private $doctrine;

    /**
     * @param Doctrine $doctrine
     */
    public function __construct(EntityManager $doctrine)
    {
        $this->doctrine = $doctrine;
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
        $identifiant = ($user) ? 'user' : 'identifiant';
        $identifiantvalue = ($user) ? $user : session_id();

        $results = $this->doctrine
        ->createQuery('SELECT c FROM AppBundle:Caddie c WHERE c.' . $identifiant . ' = :identifiant')
        ->setParameter('identifiant', $identifiantvalue)
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