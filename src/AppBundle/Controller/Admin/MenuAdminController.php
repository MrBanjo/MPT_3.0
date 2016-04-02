<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Menu;

/**
 * Menu controller.
 *
 * @Route("/admin/menu")
 */
class MenuAdminController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\MenuType';
    protected $class = 'AppBundle\Entity\Menu';
    protected $handle = 'AppBundle:Menu';
    protected $basePath = 'menu_admin';
    protected $editPath = 'edit_menu_admin';

    /**
     * @Route("/", name="menu_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $entities = $this->getRepo($this->handle)->findBy([], ['id' => 'desc']);

        return $this->render('admin/menu_admin', ['entities' => $entities]);
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/new", name="menu_new")
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
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/edit/{id}", name="edit_menu_admin")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Menu $entity)
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
     * Deletes a Menu entity.
     *
     * @Route("/delete/{id}", name="menu_delete")
     * @Method("POST")
     */
    public function deleteAction(Menu $entity)
    {
        $this->remove($entity);

        return $this->redirectToRoute($this->basePath);
    }
}
