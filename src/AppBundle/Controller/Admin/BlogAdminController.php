<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Blog;
use AppBundle\Entity\Rubriqueblog;
use AppBundle\Form\Type\RubriqueblogType;

/**
 * Caddie controller.
 *
 * @Route("/admin/blog")
 */
class BlogAdminController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\BlogType';
    protected $class = 'AppBundle\Entity\Blog';
    protected $handle = 'AppBundle:Blog';
    protected $basePath = 'blog_admin';
    protected $editPath = 'edit_blog_admin';

    /**
     * Lists all Blog entities.
     *
     * @Route("/", name="blog_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        $entities = $this->getRepo($this->handle)->findBy([], ['id' => 'desc']);

        return $this->render('admin/blog_admin', ['entities' => $entities]);
    }

    /**
     * Creates a new Blog entity.
     *
     * @Route("/new", name="blog_new")
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
     * @Route("/edit/{id}", name="edit_blog_admin")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, Blog $entity)
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
     * @Route("/categorie", name="categorie_blog_admin")
     * @Method({"GET","HEAD","POST"})
     */
    public function categorieAction(Request $request)
    {
        $rubrique = new Rubriqueblog();
        $form = $this->createForm(RubriqueblogType::class, $rubrique);

        if ($form->handleRequest($request)->isValid()) {
            $this->save($rubrique);
            $this->addFlash('info', 'La nouvelle catégorie a été créée !');

            return $this->redirectToRoute('categorie_blog_admin');
        }

        return $this->render('admin/edit', ['form' => $form->createView()]);
    }

    /**
     * Deletes a Blog entity.
     *
     * @Route("/delete/{id}", name="blog_delete")
     * @Method("POST")
     */
    public function deleteAction(Blog $entity)
    {
        $this->remove($entity);

        return $this->redirectToRoute($this->basePath);
    }

    /**
     * Creates a form to delete a Blog entity.
     *
     * @param Blog $blog The Blog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blog_delete', ['id' => $entity->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
