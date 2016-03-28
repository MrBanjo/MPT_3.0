<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaniersController extends BaseController
{
    /**
     * @Route("/paniers", name="paniers", defaults={"title": "Nos paniers"})
     * @Route("/paniers/")
     */
    public function indexAction()
    {
        return $this->render('paniers');
    }
}
