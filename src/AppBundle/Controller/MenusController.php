<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MenusController extends BaseController
{
    /**
     * @Route("/menus", name="menus", defaults={"title": "Nos menus"})
     */
    public function showCurrentMenuAction()
    {
		$curClassique = $this->getRepo('AppBundle:Menu')->getCurrentMenuClassique();
		$curVegan = $this->getRepo('AppBundle:Menu')->getCurrentMenuVegan();

		$menuvide = ['titre' => '', 'prix' => '', 'date' => ''];

		$platvide = [[
				'titre' => '', 
				'temps' => '',
				'difficulte' => '',
				'consistance' => '',
				'accroche' => '',
				'description' => '',
				'plus' => '',
				'photo' => ''
		]];

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

        return $this->render(
        	'menus', 
        	[
	        	'liste_classique' => $platsClassique,
	        	'liste_vegan' => $platsVegan,
	        	'menu_classique' => $menuClassique,
	        	'menu_vegan' => $menuVegan
        	]
        );
    }
}
