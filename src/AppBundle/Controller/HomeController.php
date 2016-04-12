<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends BaseController
{
    /**
     * @Route("/", name="accueil", defaults={"title": "Mon Panier Toqué"})
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $blogs = $this->getRepo('AppBundle:Blog')->getBlogAccueil();

        return $this->render('accueil', ['liste_blog' => $blogs]);
    }
}
