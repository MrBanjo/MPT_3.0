<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends Controller
{
    /**
     * @Route("/paniers/classique", 
     *	defaults={"title": "Panier classique"},
     *	name="classique")
     */
    public function showCurrentMenuAction()
    {
		$curClassique = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->getCurrentMenuClassique();
		$curUpsell = $this->getDoctrine()->getManager()->getRepository('AppBundle:Upsell')->getCurrentUpsell();

		$menuvide = array (
				'titre' => '', 
				'prix' => '',
				'date' => ''
				);

		$platvide = array( array (
				'titre' => '', 
				'temps' => '',
				'difficulte' => '',
				'consistance' => '',
				'accroche' => '',
				'description' => '',
				'plus' => '',
				'photo' => ''
				));

		if ( isset($curClassique[0]) ) {
			$menuClassique = $curClassique[0];
        	$platsClassique =  $curClassique[0]->getPlats();			
		}
		else {
			$menuClassique = $menuvide;
			$platsClassique = $platvide;
		}


        $params = array (
        	'liste_classique' => $platsClassique,
        	'menu_classique' => $menuClassique,
        	'liste_upsell' => $curUpsell
        	);
        return $this->render('classique.html.twig', $params);
    }

    

}
