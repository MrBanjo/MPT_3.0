<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        return $this->render('admin/adminbase.html.twig');
    }

    /**
     * @Route("/admin/edit/{id}", name="edit_admin")
     * @Method({"GET","HEAD"})
     */
    public function editAction()
    {
        return $this->render('admin/adminbase.html.twig');
    } 

}
