<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AccountController extends BaseController
{
    /**
     * @Route("/account", name="account", defaults={"title": "Votre compte"})
     */
    public function indexAction()
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
        	throw $this->createAccessDeniedException();
    	}
	
        return $this->render('account');
    }
}
