<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Entity\Role;
use AppBundle\Entity\Caddie;
use AppBundle\Entity\Upsell;
use AppBundle\Entity\Commandes;

class CartController extends Controller
{
    /**
     * @Route("/caddie/ma-commande", name="cart", defaults={"title": "Ma commande"})
     */
    public function ShowCaddieAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie');
    	// Récupère la liste des articles du client ainsi que le prix total
    	$liste_article = ($this->getUser()) ? $em->findByUser($this->getUser()) : $em->findByIdentifiant(session_id());
    	$prix_total = $em->getTotalPrix();

        return $this->render('cart.html.twig', array( 
        	'articles' => $liste_article, 
        	'prix_total' => $prix_total
        	));
    }

    /**
     * @Route("/caddie/identification", name="cart_identification", defaults={"title": "Identification"})
     */
    public function ShowIdentificationAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('cart_identification.html.twig', array(
              'form' => $form->createView(),
            ));
    }

    /**
     * @Route("/caddie/addtocart/{slug}", name="addtocart")
     */
    public function AddProductAction(Request $request, $slug)
    {
    	
    	if($request->isXmlHttpRequest() AND $request->request->get('quantite') != NULL)
    	{
    		$em = $this->getDoctrine()->getManager();

    		$caddie = new Caddie();
    		$quantite = $request->request->get('quantite');
			$produit = $em->getRepository('AppBundle:' . $slug . '')->find($request->request->get('id_product'));

    		// Recherche si le produit existe dans le caddie
    		$checkdb = $em->getRepository('AppBundle:Caddie')->getProductCaddie($request->request->get('id_product'), strtolower($slug), $this->getUser());
    		if (!empty($checkdb)) 
    		{
    			$checkdb[0]->setQuantite($quantite + $checkdb[0]->getQuantite());
    			$em->persist($checkdb[0]);
    			$em->flush();
    		}
    		// Création du produit dans le caddie
    		else 
    		{
	    		$caddie->setIdentifiant(session_id());
                $caddie->setUser($this->getUser());
	    		$caddie->setQuantite($quantite);
	    		$caddie->setPrix($produit->getPrix());
	    		$caddie->setPhoto($produit->getPhoto());
	    		($slug == 'Menu') ? $caddie->setMenu($produit) : $caddie->setUpsell($produit);
	    		$em->persist($caddie);
	    		$em->flush();			
    		}

    		return new JsonResponse(array(
    			'titre' => $produit->getTitre(),
    			'idi' => $produit->getId(),
    			'photo' => $produit->getPhoto(),
    			'quantite' => $quantite), 200);
    	}

    	return new RedirectResponse($this->generateUrl('cart'));
    }

    public function CountCaddieAction()
    {
        $identifiant = ($this->getUser()) ? 'user' : 'identifiant';
        $identifiantvalue = ($this->getUser()) ? $this->getUser() : session_id();

    	$liste_commande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie')->findBy(
            array($identifiant => $identifiantvalue)
        );

    	return new Response (count($liste_commande));
    }

    /**
     * @Route("/caddie/quantite_cart", name="quantite_cart", options={"expose"=true})
     */
    public function UpdateQuantiteAction(Request $request)
    {
    	if($request->request->get('article_id')) // Checking post 
    	{
	     	$em = $this->getDoctrine()->getManager();
	    	$commande = $em->getRepository('AppBundle:Caddie')->findOneById($request->request->get('article_id'));

		    if ($request->request->get('quantite') == 0) {
		    	$em->remove($commande); // Supprime le produit du caddie si sa quantité est 0
		    }
		    else {
		    	$commande->setQuantite($request->request->get('quantite'));
		    	$em->persist($commande);
		    }

		    $em->flush();    		
    	}

    	/*return new RedirectResponse($this->generateUrl('cart'));*/
        return new JsonResponse(array( 'prix' => $commande->getPrix()), 200);
        
    }
}
