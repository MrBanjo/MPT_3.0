<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\NewsletterType;
use AppBundle\Entity\Newsletter;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewsletterController extends Controller
{

	/**
	 * @Route("/newsletter", name="newsletter", options={"expose"=true})
	 */
	public function newsAction(Request $request)
	{
		if ( $request->isXmlHttpRequest() ) 
		{
			$news = new Newsletter();
			$newsform = $this->createForm(NewsletterType::class, $news);

			if ( $newsform->handleRequest($request)->isValid() ) 
			{
				$em = $this->getDoctrine()->getManager();
				$em->persist($news);
				$em->flush();
				
				return new JsonResponse(array('message' => 'Success'), 200);
			}

			return new JsonResponse(array('message' => 'Fail'), 200);
		}
		else
		{
			throw $this->createNotFoundException('');
		}
	}

	public function showformAction(Request $request)
	{
		$news = new Newsletter();
		$newsform = $this->createForm(NewsletterType::class, $news);
		return $this->render('form/newsletterform.html.twig', array('newsform' => $newsform->createView()));
	}
}
