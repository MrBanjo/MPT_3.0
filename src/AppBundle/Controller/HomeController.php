<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends BaseController
{
    /**
     * @Route("/accueil", name="accueil", defaults={"title": "Accueil"})
     */
    public function indexAction()
    {
		$blogs = $this->getRepo('AppBundle:Blog')->getBlogAccueil();

        return $this->render('accueil', ['liste_blog' => $blogs]);
    }
}
