<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Newsletter;

class NewsletterController extends BaseController
{
	protected $type = 'AppBundle\Form\Type\NewsletterType';

	/**
	 * @Route("/newsletter", name="newsletter", options={"expose"=true})
	 */
	public function newsAction(Request $request)
	{
		if ($request->isXmlHttpRequest()) 
		{
			$news = new Newsletter();
			$newsform = $this->getForm($news);

			if ($newsform->handleRequest($request)->isValid()) 
			{
				$this->save($news);
				
				return $this->jsonSuccess();
			}

			return $this->jsonFail();
		}
		else
		{
			throw $this->createNotFoundException('');
		}
	}

/*	public function showformAction() // Leave here for performance test purpose
	{
		$news = new Newsletter();
		$newsform = $this->createForm(NewsletterType::class, $news);
		return $this->render('form/newsletterformtest.html.twig', array('newsform' => $newsform->createView()));
	}*/
}
