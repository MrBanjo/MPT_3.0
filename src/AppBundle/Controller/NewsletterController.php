<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Newsletter;

class NewsletterController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\NewsletterType';

    /**
     * @Route("/newsletter", name="newsletter", options={"expose"=true})
     * @Method({"POST"})
     */
    public function newsAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException('');
        }
        
        $news = new Newsletter();
        $newsform = $this->getForm($news);

        if ($newsform->handleRequest($request)->isValid()) {
            $this->save($news);
            return $this->jsonSuccess();
        }

        return $this->jsonFail();
    }
}
