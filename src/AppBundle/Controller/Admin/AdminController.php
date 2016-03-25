<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use AppBundle\Form\RegisterType;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Entity\Adresse;
use AppBundle\Entity\Role;
use AppBundle\Entity\Caddie;
use AppBundle\Entity\Upsell;

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
