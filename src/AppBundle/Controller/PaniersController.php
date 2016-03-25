<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\HttpFoundation\Request;

class PaniersController extends Controller
{
    /**
     * @Route("/paniers", name="paniers", defaults={"title": "Nos paniers"})
     * @Route("/paniers/")
     */
    public function indexAction(Request $request)
    {
    	var_dump($request->get('_route'));
        return $this->render('paniers.html.twig');
    }
}
