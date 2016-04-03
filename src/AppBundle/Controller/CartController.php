<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\Caddie;

class CartController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\UserType';

    /**
     * @Route("/caddie/ma-commande", name="cart", defaults={"title": "Ma commande"})
     * @Method({"GET","HEAD"})
     */
    public function showCaddieAction()
    {
        $repo = $this->getRepo('AppBundle:Caddie');
        // Récupère la liste des articles du client ainsi que le prix total
        $articles = $repo->getAllProducts($this->getUser());
        $totalPrix = $repo->getTotalPrix($articles);

        return $this->render('cart', [
            'articles' => $articles,
            'prix_total' => $totalPrix,
        ]);
    }

    /**
     * @Route("/caddie/identification", name="cart_identification", defaults={"title": "Identification"})
     * @Method({"GET","HEAD"})
     */
    public function showIdentificationAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('cart_summary');
        }

        return $this->render('cart_identification', ['form' => $this->getForm(new User())->createView()]);
    }

    /**
     * @Route("/caddie/recapitulatif", name="cart_summary", defaults={"title": "Récapitulatif de la commande"})
     * @Method({"GET","HEAD"})
     */
    public function showSummaryAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('cart_identification');
        }

        $repo = $this->getRepo('AppBundle:Caddie');
        // Récupère la liste des articles du client ainsi que le prix total
        $articles = $repo->getAllProducts($this->getUser());
        $totalPrix = $repo->getTotalPrix($articles);

        if (empty($articles)) {
            return new RedirectResponse($this->generateUrl('cart'));
        }

        return $this->render('cart_summary', [
            'articles' => $articles,
            'prix_total' => $totalPrix,
        ]);
    }

    /**
     * @Route("/caddie/addtocart/{slug}", name="addtocart")
     * @Method({"POST"})
     */
    public function addProductAction(Request $request, $slug)
    {
        if ($request->isXmlHttpRequest() && $request->request->get('quantite') !== null) {
            $caddie = new Caddie();
            $quantite = $request->request->get('quantite');
            $produit = $this->find('AppBundle:'.$slug, $request->request->get('id_product'));

            // Recherche si le produit existe dans le caddie
            $checkdb = $this->getRepo('AppBundle:Caddie')->getProductCaddie($request->request->get('id_product'), strtolower($slug), $this->getUser());
            if (!empty($checkdb)) {
                $checkdb[0]->setQuantite($quantite + $checkdb[0]->getQuantite());
                $this->save($checkdb[0]);
            } else {
                $session = new Session();
                $caddie->setSession($session->getId());
                $caddie->setTitre($produit->getTitre());
                $caddie->setUser($this->getUser());
                $caddie->setQuantite($quantite);
                $caddie->setPrix($produit->getPrix());
                $caddie->setPhoto($produit->getPhoto());
                ($slug == 'Menu') ? $caddie->setMenu($produit) : $caddie->setUpsell($produit);
                $this->save($caddie);
            }

            return new JsonResponse([
                'titre' => $produit->getTitre(),
                'idi' => $produit->getId(),
                'photo' => $produit->getPhoto(),
                'quantite' => $quantite,
                'countcaddie' => $this->countCart(),
            ], 200);
        }

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/caddie/quantite_cart", name="quantite_cart", options={"expose"=true})
     * @Method({"POST"})
     */
    public function updateQuantiteAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $article = $this->getRepo('AppBundle:Caddie')->findOneById($request->request->get('article_id'));
            $html = false;

            if ($request->request->get('quantite') == 0) {
                $this->remove($article); // Supprime le produit du caddie si sa quantité est 0
                $html = true;
            } else {
                $article->setQuantite($request->request->get('quantite'));
                $this->save($article);
            }

            return new JsonResponse([
                'prix' => $article->getPrix(),
                'countcaddie' => $this->countCart(),
                'html' => $html,
            ], 200);
        }

        return $this->redirectToRoute('cart');
    }
}
