<?php     

namespace AppBundle\Utils; 


class CountCart extends \Twig_Extension
{

	protected $count;

    public function countcart()
    {
    	$liste_commande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie')->findByIdentifiant(session_id());

    	return count($liste_commande);
    }

	public function getName()
	    {
	        return 'CountCart';
	    }

}








