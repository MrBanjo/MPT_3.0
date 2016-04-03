<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

/**
 * Caddie controller.
 *
 * @Route("/admin/user")
 */
class UserAdminController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\UserType';
    protected $class = 'AppBundle\Entity\User';
    protected $handle = 'AppBundle:User';
    protected $basePath = 'user_admin';
    protected $editPath = 'edit_user_admin';

    /**
     * Lists all User entities.
     *
     * @Route("/", name="user_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $entities = $this->getRepo($this->handle)->findBy([], ['id' => 'desc']);

        return $this->render('admin/user_admin', ['entities' => $entities]);
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/new", name="user_new")
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
     * @Route("/edit/{id}", name="edit_user_admin")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, User $entity)
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
     * Deletes a User entity.
     *
     * @Route("/delete/{id}", name="user_delete")
     * @Method("POST")
     */
    public function deleteAction(User $entity)
    {
        $this->remove($entity);

        return $this->redirectToRoute($this->basePath);
    }
}
