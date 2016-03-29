<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {

        return $this->render('admin/adminbase.html.twig');
    }

    /**
     * @Route("/admin/edit/{id}", name="edit_admin")
     */
    public function editAction()
    {

        return $this->render('admin/adminbase.html.twig');
    } 

}
