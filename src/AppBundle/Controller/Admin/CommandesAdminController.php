<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Commandes;

/**
 * Caddie controller.
 *
 * @Route("/admin/commandes")
 */
class CommandesAdminController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\CommandesType';
    protected $class = 'AppBundle\Entity\Commandes';
    protected $handle = 'AppBundle:Commandes';
    protected $basePath = 'commandes_admin';
    protected $editPath = 'edit_commandes_admin';

    /**
     * Lists all Commandes entities.
     *
     * @Route("/", name="commandes_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $entities = $this->getRepo($this->handle)->findBy([], ['id' => 'desc']);

        return $this->render('admin/commandes_admin', ['entities' => $entities]);
    }

    /**
     * Creates a new Commandes entity.
     *
     * @Route("/new", name="commandes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = $this->createEntity($this->class);
        $form = $this->getForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($entity);
            $this->addFlash('info', 'Création réussie');

            return $this->redirectToRoute($this->basePath);
        }

        return $this->render('admin/edit', ['form' => $form->createView()]);
    }

    /**
     * Displays a form to edit an existing Caddie entity.
     *
     * @Route("/edit/{id}", name="edit_commandes_admin")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Commandes $entity)
    {
        $form = $this->getForm($entity);

        if ($form->handleRequest($request)->isValid()) {
            $this->save($entity);
            $this->addFlash('info', 'Modification réussie.');

            return $this->redirectToRoute($this->editPath, ['id' => $entity->getId(),]);
        }

        return $this->render('admin/edit', [
              'form' => $form->createView(),
              'id' => $entity->getId()
            ]);
    }

    /**
     * Deletes a Commandes entity.
     *
     * @Route("/delete/{id}", name="commandes_delete")
     * @Method("POST")
     */
    public function deleteAction(Commandes $entity)
    {
        $this->remove($entity);

        return $this->redirectToRoute($this->basePath);
    }
}
