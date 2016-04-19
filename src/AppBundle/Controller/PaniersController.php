<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Categorie;

/**
 * @Route("/paniers")
 */
class PaniersController extends BaseController
{
    /**
     * @Route("", name="paniers", defaults={"title": "Nos paniers - Mon Panier Toqué"})
     * @Method({"GET","HEAD"})
     */
    public function showPaniersAction()
    {
        return $this->render('paniers');
    }

    /**
     * @Route("/{slug}", name="panier", defaults={"title": "Notre panier - Mon Panier Toqué"})
     * @Method({"GET","HEAD"})
     * @ParamConverter("categorie", options={"mapping": {"slug": "nom"}})
     */
    public function showPanierTypeAction($slug, Categorie $categorie = null)
    {
        if (empty($categorie)) {
            return $this->redirectToRoute('paniers');
        }

        $menu = $this->getRepo('AppBundle:Menu')->getCurrentMenu($slug);
        $curUpsell = $this->getRepo('AppBundle:Upsell')->getCurrentUpsell();

        if (!$menu) {
            return $this->redirectToRoute('paniers');
        }

        return $this->render('panier', [
            'plats' => $menu->getPlats(),
            'menu' => $menu,
            'liste_upsell' => $curUpsell
        ]);
    }
}
