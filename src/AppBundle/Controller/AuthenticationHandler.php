<?php 

namespace AppBundle\Controller;
 
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
	 * Constructor
	 * @param 	RouterInterface $router
	 * @param 	Session $session
	 * @param   EntityManager $em
	 */
	public function __construct(RouterInterface $router, Session $session, EntityManager $doctrine, TokenStorageInterface $security)
	{
		$this->router  = $router;
		$this->session = $session;
		$this->doctrine = $doctrine;
		$this->security = $security;
	}
 
	/**
	 * onAuthenticationSuccess
	 * @param 	Request $request
	 * @param 	TokenInterface $token
	 * @return 	Response
	 */
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		// Donne aux produits dans le panier un user_id si le client se connecte
        $user = $this->security->getToken()->getUser();
        $this->doctrine->getRepository('AppBundle:Caddie')->switchSessionToUserProduct($user);

		// if AJAX login
		if ($request->isXmlHttpRequest()) {
 
			$array = array( 'success' => true ); // data to return via JSON
			$response = new Response( json_encode( $array ) );
			$response->headers->set( 'Content-Type', 'application/json' );
 
			return $response;
 
		// if form login 
		} else {
 
			if ($this->session->get('_security.main.target_path')) {
 
				$url = $this->session->get('_security.main.target_path');
 
			} else if ($request->headers->get('referer')) {

				$url = $request->headers->get('referer');

			} else {
 
				$url = $this->router->generate( 'accueil' );
 
			} // end if
 
			return new RedirectResponse($url);
 
		}
	}
 
	/**
	 * onAuthenticationFailure
	 *
	 * @param 	Request $request
	 * @param 	AuthenticationException $exception
	 * @return 	Response
	 */
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		// if AJAX login
		if ( $request->isXmlHttpRequest() ) {
 
			$array = array( 'success' => false, 'message' => $exception->getMessage() ); // data to return via JSON
			$response = new Response( json_encode( $array ) );
			$response->headers->set( 'Content-Type', 'application/json' );

			return $response;
 			
		// if form login 
		} else {
 
			// set authentication exception to session
			$request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);

			return new RedirectResponse( $this->router->generate( 'login' ) );
		}
	}
}
