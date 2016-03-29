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
        $results = $this->doctrine
        ->createQuery('SELECT c FROM AppBundle:Caddie c WHERE (c.user = :name1 OR c.identifiant = :name2)')
        ->setParameter('name1', $user)
        ->setParameter('name2', session_id())
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
