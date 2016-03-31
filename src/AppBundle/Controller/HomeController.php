<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends BaseController
{
    /**
     * @Route("/accueil", name="accueil", defaults={"title": "Accueil"})
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $blogs = $this->getRepo('AppBundle:Blog')->getBlogAccueil();

        return $this->render('accueil', ['liste_blog' => $blogs]);
    }
}
