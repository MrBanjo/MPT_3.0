<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\MenuType;
use AppBundle\Entity\Menu;

class MenuAdminController extends Controller
{
    /**
     * @Route("/admin/menu", name="menu_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $liste_menu = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->getMenuAdmin();

        $params = array('liste_menu' => $liste_menu);

        return $this->render('admin/menu_admin.html.twig', $params);
    }

    /**
     * @Route("/admin/menu/edit/{id}", name="edit_menu_admin")
     * @Method({"GET","HEAD","POST"})
     */
    public function editAction(Request $request, $id)
    {
        $menu = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->find($id);
        $message = '';

        if ($menu === null) {
            $menu = new Menu();
        }

        $form = $this->createForm(new MenuType(), $menu);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $message = 'Le menu a été créé !';
        }

        return $this->render('admin/edit.html.twig', array(
              'form' => $form->createView(),
              'id' => $menu->getId(),
              'message' => $message,
            ));
    }

    /**
     * @Route("/admin/menu/erase", name="menu_erase")
     * @Method({"POST"})
     */
    public function eraseAction(Request $request)
    {
        if ($request->request->get('erase')) {
            $menu = $this->getDoctrine()->getManager()->getRepository('AppBundle:Menu')->find($request->request->get('erase'));

            $em = $this->getDoctrine()->getManager();
            $em->remove($menu);
            $em->flush();
        }

        return new RedirectResponse($this->generateUrl('menu_admin'));
    }
}
