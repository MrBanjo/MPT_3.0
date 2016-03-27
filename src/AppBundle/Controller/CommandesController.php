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
use AppBundle\Entity\Commandes;

class CommandesController extends Controller
{

    /**
    * @Route("/dzqdzqdqzd/fesfesfes", name="addcommandes")
    */     
    public function AddCommandes(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listecommandes = $em->getRepository('AppBundle:Commandes')->getCommandes();

        foreach ($listecommandes as $listecommande) {

            $commandes = new Commandes();
            $produitname = ($listecommande->getUpsell()) ? $listecommande->getUpsell()->getTitre() : $listecommande->getMenu()->getTitre();
            $commandes->setQuantite($listecommande->getQuantite());
            $commandes->setUser(66);
            $commandes->setReference("5555");
            $commandes->setStatus("En cours");
            $commandes->setPrix($listecommande->getPrix());
            $commandes->setDate(new \DateTime('now'));
            $commandes->setProduit($produitname);
            $em->persist($commandes);
            $em->flush();
        }

        return new RedirectResponse($this->generateUrl('cart'));
    }
}