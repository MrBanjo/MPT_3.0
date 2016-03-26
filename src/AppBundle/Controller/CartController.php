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

class CartController extends Controller
{
    /**
     * @Route("/caddie/ma-commande", name="cart", defaults={"title": "Ma commande"})
     */
    public function ShowCaddieAction()
    {
    	// Récupère la liste des articles du client ainsi que le prix total
    	$liste_article = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie')->findByIdentifiant(session_id());
    	$prix_total = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie')->getTotalPrix();

        return $this->render('cart.html.twig', array( 
        	'articles' => $liste_article, 
        	'prix_total' => $prix_total
        	));
    }

    /**
     * @Route("/caddie/identification", name="cart_identification", defaults={"title": "Identification"})
     */
    public function ShowIdentificationAction(Request $request)
    {
    	$url = $request->getSession()->get('_security.target_path');
    	$referer_url = $request->headers->get('referer');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            // On donne un pseudo (le meme que l'email)
            $user->setUsername($user->getEmail());
            // On encode le password
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            // On ajoute le role au nouvel utilisateur
            $role = $em->getRepository('AppBundle:Role')->findOneByRole("ROLE_USER");
            $user->addRole($role);
            // On enregistre dans la bdd
            $em->persist($user);
            $em->flush();

            // Création d'un nouveau token basé sur l'utilisateur qui vient de s'inscrire
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            // On passe le token créé au service security context afin que l'utilisateur soit authentifié
            $this->get('security.token_storage')->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

        return $this->render('cart_identification.html.twig', array(
              'form' => $form->createView(),
              'url' => $url,
              'referer' => $referer_url
            ));
    }

    /**
     * @Route("/caddie/addtocart/{slug}", name="addtocart")
     */
    public function AddProductAction(Request $request,$slug)
    {
    	
    	if($request->isXmlHttpRequest() AND $request->request->get('quantite') != NULL)
    	{
    		$em = $this->getDoctrine()->getManager();

    		$caddie = new Caddie();
    		$quantite = $request->request->get('quantite');
			$produit = $em->getRepository('AppBundle:' . $slug . '')->find($request->request->get('id_product'));

    		// Recherche si le produit existe dans le caddie
    		$checkdb = $em->getRepository('AppBundle:Caddie')->getProductCaddie($request->request->get('id_product'), strtolower($slug));
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
    	$liste_commande = $this->getDoctrine()->getManager()->getRepository('AppBundle:Caddie')->findByIdentifiant(session_id());

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
