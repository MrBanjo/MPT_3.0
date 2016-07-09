<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManager;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    private $router;
    private $session;
    private $doctrine;
    private $security;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     * @param Session         $session
     * @param EntityManager   $em
     */
    public function __construct(RouterInterface $router, Session $session, EntityManager $doctrine)
    {
        $this->router = $router;
        $this->session = $session;
        $this->doctrine = $doctrine;
    }

    /**
     * onAuthenticationSuccess.
     *
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        // Donne aux produits dans le panier un user_id si le client se connecte
        $user = $token->getUser();
        $this->doctrine->getRepository('AppBundle:Caddie')->switchSessionToUserProduct($user);

        $url = $this->router->generate('accueil');
        if ($this->session->get('_security.main.target_path')) {
            $url = $this->session->get('_security.main.target_path');
        } elseif ($this->session->get('old_referer')) {
            $url = $this->session->get('old_referer');
        } elseif ($request->headers->get('referer')) {
            $url = $request->headers->get('referer');
        }

        // Normal login
        if (!$request->isXmlHttpRequest()) {
            return new RedirectResponse($url);
        }
        // AJAX login
        $array = array('success' => true, 'url' => $url); // data to return via JSON
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * onAuthenticationFailure.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        // Normal login
        if (!$request->isXmlHttpRequest()) {
            // set authentication exception to session
            $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
            return new RedirectResponse($request->headers->get('referer'));
        }

        // AJAX login
        $array = array('success' => false, 'message' => $exception->getMessage()); // data to return via JSON
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
