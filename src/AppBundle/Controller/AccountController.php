<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AccountController extends BaseController
{
    /**
     * @Route("/account", name="account", defaults={"title": "Votre compte"})
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $commandes = $this->findBy('AppBundle:Commandes', ['user' => $this->getUser()]);
        $price = $this->getRepo('AppBundle:Caddie')->getTotalPrix($commandes);

        return $this->render('account', [
            'commandes' => $commandes,
            'price' => $price
        ]);
    }
}
