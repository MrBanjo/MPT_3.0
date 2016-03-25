<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/accueil", name="accueil", defaults={"title": "Accueil"})
     */
    public function indexAction()
    {

		$blogs = $this->getDoctrine()->getManager()->getRepository('AppBundle:Blog')->getBlogAccueil();   	

		$params = array(
			'liste_blog' => $blogs
			);

        return $this->render('accueil.html.twig', $params);
    }

}
