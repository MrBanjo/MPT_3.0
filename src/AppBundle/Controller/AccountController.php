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
	
        return $this->render('account');
    }
}
