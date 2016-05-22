<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MenusController extends BaseController
{
    /**
     * @Route("/menus", name="menus", defaults={"title": "Nos menus - Mon Panier Toqué"})
     * @Method({"GET","HEAD"})
     */
    public function showCurrentMenuAction()
    {
        $curClassique = $this->getRepo('AppBundle:Menu')->getCurrentMenu('classique');
        $curVegan = $this->getRepo('AppBundle:Menu')->getCurrentMenu('végétarien');

        $menuvide = ['titre' => '', 'prix' => '', 'date' => ''];

        $platvide = [[
                'titre' => '',
                'temps' => '',
                'difficulte' => '',
                'consistance' => '',
                'accroche' => '',
                'description' => '',
                'plus' => '',
                'photo' => '',
        ]];

        if (isset($curClassique)) {
            $menuClassique = $curClassique;
            $platsClassique = $curClassique->getPlats();
        } else {
            $menuClassique = $menuvide;
            $platsClassique = $platvide;
        }

        if (isset($curVegan)) {
            $menuVegan = $curVegan;
            $platsVegan = $curVegan->getPlats();
        } else {
            $menuVegan = $menuvide;
            $platsVegan = $menuvide;
        }

        return $this->render(
            'menus',
            [
                'liste_classique' => $platsClassique,
                'liste_vegan' => $platsVegan,
                'menu_classique' => $menuClassique,
                'menu_vegan' => $menuVegan,
            ]
        );
    }
}
