<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Role;


class UserController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {   
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        if ($form->handleRequest($request)->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            // On donne un pseudo (le meme que l'email)
            $user->setUsername($user->getPrenom());
            // On encode le password
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            // On ajoute le role au nouvel utilisateur
            $role = $em->getRepository('AppBundle:Role')->findOneByRole("ROLE_USER");
            $user->addRole($role);
            // On enregistre dans la bdd
            $em->persist($user);
            $em->flush();

            // Création d'un nouveau token basé sur l'utilisateur qui vient de s'inscrire
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            // On passe le token créé au service security context afin que l'utilisateur soit authentifié
            $this->get('security.token_storage')->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

        return $this->render('login.html.twig', array(
            'form' => $form->createView()
            ));
    }

    /**
     * @Route("/checkMail/{data}", name="checkMail", defaults={"data" = ""})
     */
    public function checkEmail($data)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->findOneByEmail($data);

        if ( $user ) {
            return new JsonResponse(array('titre' => $data , 200));
        }

    }



}
