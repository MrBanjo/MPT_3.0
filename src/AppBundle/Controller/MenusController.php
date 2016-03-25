<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Menu; // notre entité
use AppBundle\Entity\Categorie; // notre entité

class MenusController extends Controller
{
    /**
     * @Route("/menus", name="menus", defaults={"title": "Nos menus"})
     */
    public function showCurrentMenuAction()
    {
		$curClassique = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->getCurrentMenuClassique();
		$curVegan = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->getCurrentMenuVegan();

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

		if ( isset($curVegan[0]) ) {
			$menuVegan = $curVegan[0];
        	$platsVegan =  $curVegan[0]->getPlats();			
		}
		else {
			$menuVegan = $menuvide;
			$platsVegan = $menuvide;
		}

        $params = array (
        	'liste_classique' => $platsClassique,
        	'liste_vegan' => $platsVegan,
        	'menu_classique' => $menuClassique,
        	'menu_vegan' => $menuVegan
        	);

        return $this->render('menus.html.twig', $params);
    }
}
