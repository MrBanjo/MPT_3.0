<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PanierController extends BaseController
{
    /**
     * @Route("/paniers/classique", defaults={"title": "Panier classique"}, name="classique")
     * @Method({"GET","HEAD"})
     */
    public function showCurrentMenuAction()
    {
        $curClassique = $this->getRepo('AppBundle:Menu')->getCurrentMenuClassique();
        $curUpsell = $this->getRepo('AppBundle:Upsell')->getCurrentUpsell();

        $menuvide = ['titre' => '', 'prix' => '', 'date' => ''];
        $platvide = [
            [
                'titre' => '',
                'temps' => '',
                'difficulte' => '',
                'consistance' => '',
                'accroche' => '',
                'description' => '',
                'plus' => '',
                'photo' => '',
            ],
        ];

        if (isset($curClassique[0])) {
            $menuClassique = $curClassique[0];
            $platsClassique = $curClassique[0]->getPlats();
        } else {
            $menuClassique = $menuvide;
            $platsClassique = $platvide;
        }

        return $this->render(
            'classique',
            [
                'liste_classique' => $platsClassique,
                'menu_classique' => $menuClassique,
                'liste_upsell' => $curUpsell,
            ]
        );
    }
}
