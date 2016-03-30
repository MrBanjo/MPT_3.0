<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PaniersController extends BaseController
{
    /**
     * @Route("/paniers", name="paniers", defaults={"title": "Nos paniers"})
     * @Route("/paniers/")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        return $this->render('paniers');
    }
}
