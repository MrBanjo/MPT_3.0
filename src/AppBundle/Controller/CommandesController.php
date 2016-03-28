<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Commandes;

class CommandesController extends BaseController
{
    /**
    * @Route("/caddie/validatecommande", name="addcommandes")
    */     
    public function createCommandes(Request $request)
    {
        if ($this->getUser()) {
            $user = $this->getUser();
            $listecommandes = $this->getRepo('AppBundle:Caddie')->getAllProducts($user);
            $ref = time() . rand(10*45, 100*98);

            foreach ($listecommandes as $listecommande) {

                $commandes = new Commandes();
                $produitname = ($listecommande->getUpsell()) ? $listecommande->getUpsell()->getTitre() : $listecommande->getMenu()->getTitre();
                $commandes->setQuantite($listecommande->getQuantite());
                $commandes->setUser($user);
                $commandes->setReference($ref);
                $commandes->setStatus("En cours");
                $commandes->setPrix($listecommande->getPrix());
                $commandes->setDate(new \DateTime('now'));
                $commandes->setProduit($produitname);
                $this->save($commandes); 
                $this->remove($listecommande); // remove product from cart
            }

            return new RedirectResponse($this->generateUrl('cart'));           
        }

        return new RedirectResponse($this->generateUrl('cart_identification'));
    }
}