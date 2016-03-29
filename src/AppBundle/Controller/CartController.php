<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Caddie;

class CartController extends BaseController
{
    protected $type = 'AppBundle\Form\UserType';

    /**
     * @Route("/caddie/ma-commande", name="cart", defaults={"title": "Ma commande"})
     */
    public function ShowCaddieAction()
    {
        $em = $this->getRepo('AppBundle:Caddie');
    	// Récupère la liste des articles du client ainsi que le prix total
    	$liste_article = $em->getAllProducts($this->getUser());
    	$prix_total = $em->getTotalPrix($this->getUser());

        return $this->render(
            'cart', 
            [ 
            	'articles' => $liste_article, 
            	'prix_total' => $prix_total
        	]
        );
    }

    /**
     * @Route("/caddie/identification", name="cart_identification", defaults={"title": "Identification"})
     */
    public function ShowIdentificationAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('cart_summary');
        }

        return $this->render('cart_identification', ['form' => $this->getForm(new User())->createView()]);
    }

    /**
     * @Route("/caddie/recapitulatif", name="cart_summary", defaults={"title": "Récapitulatif de la commande"})
     */
    public function ShowSummaryAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('cart_identification');
        }

        $em = $this->getRepo('AppBundle:Caddie');
        // Récupère la liste des articles du client ainsi que le prix total
        $liste_article = $em->getAllProducts($this->getUser());
        $prix_total = $em->getTotalPrix($this->getUser());

        return $this->render(
            'cart_summary', 
            [ 
                'articles' => $liste_article, 
                'prix_total' => $prix_total
            ]
        );
    }

    /**
     * @Route("/caddie/addtocart/{slug}", name="addtocart")
     */
    public function AddProductAction(Request $request, $slug)
    {
    	
    	if($request->isXmlHttpRequest() AND $request->request->get('quantite') != NULL)
    	{
    		$caddie = new Caddie();
    		$quantite = $request->request->get('quantite');
			$produit = $this->find('AppBundle:' . $slug, $request->request->get('id_product'));

    		// Recherche si le produit existe dans le caddie
    		$checkdb = $this->getRepo('AppBundle:Caddie')->getProductCaddie($request->request->get('id_product'), strtolower($slug), $this->getUser());
    		if (!empty($checkdb)) 
    		{
    			$checkdb[0]->setQuantite($quantite + $checkdb[0]->getQuantite());
    			$this->save($checkdb[0]);
    		}
    		// Création du produit dans le caddie
    		else 
    		{
	    		$caddie->setIdentifiant(session_id());
                $caddie->setTitre($produit->getTitre());
                $caddie->setUser($this->getUser());
	    		$caddie->setQuantite($quantite);
	    		$caddie->setPrix($produit->getPrix());
	    		$caddie->setPhoto($produit->getPhoto());
	    		($slug == 'Menu') ? $caddie->setMenu($produit) : $caddie->setUpsell($produit);
	    		$this->save($caddie);		
    		}

    		return new JsonResponse(
                [
        			'titre' => $produit->getTitre(),
        			'idi' => $produit->getId(),
        			'photo' => $produit->getPhoto(),
        			'quantite' => $quantite,
                    'countcaddie' => $this->countCart()
                ], 200
            );
    	}

    	return new RedirectResponse($this->generateUrl('cart'));
    }

    /**
     * @Route("/caddie/quantite_cart", name="quantite_cart", options={"expose"=true})
     */
    public function UpdateQuantiteAction(Request $request)
    {
    	if($request->request->get('article_id')) // Checking post 
    	{
	    	$article = $this->getRepo('AppBundle:Caddie')->findOneById($request->request->get('article_id'));
            $html = false;

		    if ($request->request->get('quantite') == 0) {
		    	$this->remove($article); // Supprime le produit du caddie si sa quantité est 0
                $html = true;
		    }
		    else {
		    	$article->setQuantite($request->request->get('quantite'));
		    	$this->save($article);
		    }

            return new JsonResponse(
                [
                    'prix' => $article->getPrix(),
                    'countcaddie' => $this->countCart(),
                    'html' => $html
                ], 200
            );    		
    	}
        
    	return new RedirectResponse($this->generateUrl('cart'));
    }
}
