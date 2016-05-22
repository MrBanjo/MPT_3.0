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
     * @param Session $session
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
        if ($user) {
            return count($user->getCaddies());
        } else {
            $results = $this->doctrine
            ->createQuery('SELECT c FROM AppBundle:Caddie c WHERE c.session = :session')
            ->setParameter('session', $this->session->getId())
            ->getResult();

            return count($results);
        }
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'cart';
    }
}
