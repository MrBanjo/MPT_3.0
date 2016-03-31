<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Caddie;
use AppBundle\Form\CaddieType;

/**
 * Caddie controller.
 *
 * @Route("/mpt_caddie")
 */
class CaddieController extends Controller
{
    /**
     * Lists all Caddie entities.
     *
     * @Route("/", name="mpt_caddie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $caddies = $em->getRepository('AppBundle:Caddie')->findAll();

        return $this->render('caddie/index.html.twig', array(
            'caddies' => $caddies,
        ));
    }

    /**
     * Creates a new Caddie entity.
     *
     * @Route("/new", name="mpt_caddie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $caddie = new Caddie();
        $form = $this->createForm('AppBundle\Form\CaddieType', $caddie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caddie);
            $em->flush();

            return $this->redirectToRoute('mpt_caddie_show', array('id' => $caddie->getId()));
        }

        return $this->render('caddie/new.html.twig', array(
            'caddie' => $caddie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Caddie entity.
     *
     * @Route("/{id}", name="mpt_caddie_show")
     * @Method("GET")
     */
    public function showAction(Caddie $caddie)
    {
        $deleteForm = $this->createDeleteForm($caddie);

        return $this->render('caddie/show.html.twig', array(
            'caddie' => $caddie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Caddie entity.
     *
     * @Route("/{id}/edit", name="mpt_caddie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Caddie $caddie)
    {
        $deleteForm = $this->createDeleteForm($caddie);
        $editForm = $this->createForm('AppBundle\Form\CaddieType', $caddie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($caddie);
            $em->flush();

            return $this->redirectToRoute('mpt_caddie_edit', array('id' => $caddie->getId()));
        }

        return $this->render('caddie/edit.html.twig', array(
            'caddie' => $caddie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Caddie entity.
     *
     * @Route("/{id}", name="mpt_caddie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Caddie $caddie)
    {
        $form = $this->createDeleteForm($caddie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($caddie);
            $em->flush();
        }

        return $this->redirectToRoute('mpt_caddie_index');
    }

    /**
     * Creates a form to delete a Caddie entity.
     *
     * @param Caddie $caddie The Caddie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Caddie $caddie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mpt_caddie_delete', array('id' => $caddie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
