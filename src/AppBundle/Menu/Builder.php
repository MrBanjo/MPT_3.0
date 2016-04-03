<?php

  namespace AppBundle\Menu;

  use Knp\Menu\FactoryInterface;
  use Symfony\Component\HttpFoundation\RequestStack;

class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;
    private $requestStack;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    /**
     * @param array $options,
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem('Accueil', ['route' => 'accueil']);
        // cet item sera toujours affiché
        $menu->addChild('Accueil', ['route' => 'accueil']);

        // crée le menu en fonction de la route
        switch ($this->requestStack->getCurrentRequest()->getPathInfo()) {
            case '/caddie/ma-commande':
                $menu
                    ->addChild('Ma commande', array('route' => 'cart'))
                    ->setCurrent(true)
                    // setCurrent est utilisé pour ajouter une classe css "current"
                ;
                break;
            case 'cart_identification':
                $menu
                    ->addChild('mon caddie', array('route' => 'cart'));
                    $menu->addChild('identification')
                    ->setCurrent(true)
                ;
                break;
            case '/paniers':
                $menu->addChild('Nos paniers', array('route' => 'paniers'));
                $menu->setCurrent(true)
                ;
                
                break;
            case '/paniers/classique':
                $menu->addChild('Nos paniers', array('route' => 'paniers'));
                $menu->addChild('Panier classique', array('route' => 'classique'))
                     ->setCurrent(true)
                ;
                break;
            case '/menus':
                $menu->addChild('Nos menus', array('route' => 'menus'))
                     ->setCurrent(true)
                ;
                break;
        }

        return $menu;
    }
}
