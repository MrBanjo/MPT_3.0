<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Commandes;
use Doctrine\Common\Collections\ArrayCollection;

class CommandesController extends BaseController
{
    /**
     * @Route("/caddie/commande-validée", name="addcommandes", defaults={"title": "Commande validée - Mon Panier Toqué"})
     * @Method({"POST","GET","HEAD"})
     */
    public function createCommandesAction()
    {
        if ($this->getUser()) {
            $user = $this->getUser();
            $listecommandes = $this->getRepo('AppBundle:Caddie')->getAllProducts($user);

            if (empty($listecommandes)) {
                return new RedirectResponse($this->generateUrl('cart'));
            }

            $totalPrix = $this->getRepo('AppBundle:Caddie')->getTotalPrix($listecommandes);
            $ref = time().rand(10 * 45, 100 * 98);

            $collections = new ArrayCollection($listecommandes);
            $commande = new Commandes();
            $commande->setReference($ref);
            $commande->setStatus(1);
            $commande->setPrix($totalPrix);
            $commande->setDate(new \DateTime('now'));
            $commande->setUser($user);
            $commande->setQuantite(count($listecommandes));

            foreach ($listecommandes as $listecommande) {
                $this->remove($listecommande, false);
            }
            $commande->setProduit($collections);
            $this->persist($commande);
            $this->flush();

            return $this->render('cart_validate', ['prix' => $totalPrix]);
        }

        return new RedirectResponse($this->generateUrl('cart_identification'));
    }
}
