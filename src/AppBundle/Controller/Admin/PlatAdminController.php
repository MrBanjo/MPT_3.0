<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Plat;

/**
 * Caddie controller.
 *
 * @Route("/admin/plat")
 */
class PlatAdminController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\PlatType';
    protected $class = 'AppBundle\Entity\Plat';
    protected $handle = 'AppBundle:Plat';
    protected $basePath = 'plat_admin';
    protected $editPath = 'edit_plat_admin';

    /**
     * Lists all Plat entities.
     *
     * @Route("/", name="plat_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $entities = $this->getRepo($this->handle)->findBy([], ['id' => 'desc']);

        return $this->render('admin/plat_admin', ['entities' => $entities]);
    }

    /**
     * Creates a new Plat entity.
     *
     * @Route("/new", name="plat_new")
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
     * @Route("/edit/{id}", name="edit_plat_admin")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Plat $entity)
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
     * Deletes a Plat entity.
     *
     * @Route("/delete/{id}", name="plat_delete")
     * @Method("POST")
     */
    public function deleteAction(Plat $entity)
    {
        $this->remove($entity);

        return $this->redirectToRoute($this->basePath);
    }
}
