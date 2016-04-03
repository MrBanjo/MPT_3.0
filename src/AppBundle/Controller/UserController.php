<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\User;

class UserController extends BaseController
{
    protected $type = 'AppBundle\Form\Type\UserType';

    /**
     * @Route("/login", name="login")
     * @Method({"GET","HEAD","POST"})
     */
    public function loginAction(Request $request)
    {
        if ($request->headers->get('referer') != $this->generateURL('login', [], UrlGeneratorInterface::ABSOLUTE_URL)) {
            $this->get('session')->set('old_referer', $request->headers->get('referer'));
        }

        return $this->render('login', ['form' => $this->getForm(new User())->createView()]);
    }

    /**
     * @Route("/account/register", name="register_user")
     * @Method({"POST"})
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $saveform = $this->getForm($user);

        if ($saveform->handleRequest($request)->isValid()) {
            // On donne un pseudo (le meme que l'email)
            $user->setUsername($user->getEmail());
            // On encode le password
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            // On ajoute le role au nouvel utilisateur
            $role = $this->getRepo('AppBundle:Role')->findOneByRole('ROLE_USER');
            $user->addRole($role);
            // On enregistre dans la bdd
            $this->save($user);

            // Création d'un nouveau token basé sur l'utilisateur qui vient de s'inscrire
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            // On passe le token créé au service security context afin que l'utilisateur soit authentifié
            $this->get('security.token_storage')->setToken($token);
            $event = new InteractiveLoginEvent($request, $token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            return $this->container->get('login_handler')->onAuthenticationSuccess($request, $token);
        }

        $flashbag = preg_replace(['/ERROR/'], ['ERREUR'], (string) $saveform->getErrors(true, false));
        $this->get('session')->getFlashBag()->add('errora', $flashbag);
        
        return new RedirectResponse($request->headers->get('referer'));
    }

    /**
     * @Route("/checkMail/{data}", name="checkMail", defaults={"data" = ""}, options={"expose"=true})
     * @Method({"POST"})
     */
    public function checkEmailAction($data)
    {
        $user = $this->getRepo('AppBundle:User')->findOneByEmail($data);

        return ($user) ? $this->jsonSuccess() : $this->jsonFail();
    }
}
