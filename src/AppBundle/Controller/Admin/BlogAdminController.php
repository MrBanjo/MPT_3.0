<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Blog;
use AppBundle\Form\Type\BlogType;
use AppBundle\Entity\Rubriqueblog;
use AppBundle\Form\Type\RubriqueblogType; 

class BlogAdminController extends Controller
{
    /**
     * @Route("/admin/blog", name="blog_admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {

  		$liste_blog = $this->getDoctrine()->getManager()->getRepository('AppBundle:Blog')->getBlogAdmin();

  		$params = array('liste_blog' => $liste_blog);

        return $this->render('admin/blog_admin.html.twig', $params);
    }

    /**
     * @Route("/admin/blog/edit/{id}", name="edit_blog_admin")
     * @Method({"GET","HEAD","POST"})
     */
    public function editAction(Request $request,$id)
    {

    	$blog = $this->getDoctrine()->getManager()->getRepository('AppBundle:Blog')->find($id);

      $message = '';

    	if($blog === null) {
    		$blog = new Blog();
    	}

    	$form = $this->createForm(new BlogType(), $blog);

	    if ($form->handleRequest($request)->isValid()) 
	    {
	        $em = $this->getDoctrine()->getManager();
	        $em->persist($blog);
	        $em->flush();

          $message = 'Le nouveau blog a été créer !';     
      }

        return $this->render('admin/edit.html.twig', array(
              'form' => $form->createView(),
              'id' => $blog->getId(),
              'message' => $message
            ));

    }

    /**
     * @Route("/admin/blog/erase", name="blog_erase")
     * @Method({"POST"})
     */
    public function eraseAction(Request $request)
    {

    	if($request->request->get('erase'))
    	{

			$blog = $this->getDoctrine()->getManager()->getRepository('AppBundle:Blog')->find($request->request->get('erase'));

			$em = $this->getDoctrine()->getManager();
			$em->remove($blog);
			$em->flush();
    	}

        return new RedirectResponse($this->generateUrl('blog_admin'));
    }

    /**
     * @Route("/admin/blog/categorie", name="categorie_blog_admin")
     * @Method({"GET","HEAD","POST"})
     */
    public function categorieAction(Request $request)
    {

      $rubrique = new Rubriqueblog();
      $message = '';
      $form = $this->createForm(new RubriqueblogType(), $rubrique);

      if ($form->handleRequest($request)->isValid()) 
      {
          $em = $this->getDoctrine()->getManager();
          $em->persist($rubrique);
          $em->flush();

          $message = 'La nouvelle catégorie a été créée !';     
      }

      return $this->render('admin/edit.html.twig', array(
              'form' => $form->createView(),
              'message' => $message
            ));
    }

}
