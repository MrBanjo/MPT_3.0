<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends Controller
{
    protected $class = 'class_here';
    protected $basePath = 'base_path_here';
    protected $type = 'type_here';

    protected function getForm($data = null, array $options = [])
    {
        return parent::createForm($this->type, $data, $options);
    }

    protected function render($view, array $parameters = [], Response $response = null)
    {
        return parent::render($view.'.html.twig', $parameters);
    }

    protected function persist($entity)
    {
        $this->getDoctrine()->getManager()->persist($entity);
    }

    protected function flush()
    {
        $this->getDoctrine()->getManager()->flush();
    }

    protected function getRepo($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }

    protected function find($handle, $id)
    {
        return $this->getRepo($handle)->find($id);
    }

    protected function findBy($handle, array $champs, array $order = [], $limit = null, $offset = null)
    {
        return $this->getRepo($handle)->findBy($champs, $order, $limit, $offset);
    }

    protected function findAll($handle)
    {
        return $this->getRepo($handle)->findAll();
    }

    protected function save($object, $flush = true)
    {
        $this->getDoctrine()->getManager()->persist($object);
        if ($flush) {
            $this->getDoctrine()->getManager()->flush();
        }
    }

    protected function remove($object, $flush = true)
    {
        $this->getDoctrine()->getManager()->remove($object);
        if ($flush) {
            $this->getDoctrine()->getManager()->flush();
        }
    }

    protected function createEntity($entity)
    {
        return new $entity();
    }

    protected function redirectTo($path, array $params = [])
    {
        return $this->redirect($this->generateUrl($path, $params));
    }

    protected function jsonSuccess()
    {
        return new JsonResponse(['message' => 'success'], 200);
    }

    protected function jsonFail()
    {
        return new JsonResponse(['message' => 'fail'], 200);
    }

    protected function countCart()
    {
        $cartExtension = $this->container->get('app.twig.cart_extension');
        $countCart = $cartExtension->countCart($this->getUser());

        return $countCart;
    }
}
