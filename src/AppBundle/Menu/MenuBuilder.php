<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class MenuBuilder
{
    private $factory;
    private $tokenStorage;

    public function __construct(FactoryInterface $factory, TokenStorage $tokenStorage)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav navbar-left',
            ],
        ]);
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Games', ['route' => 'game_index']);
        $menu->addChild('Developers', ['route' => 'developer_index']);

        return $menu;
    }

    public function createUserMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav navbar-right',
            ],
        ]);

        if ($token = $this->tokenStorage->getToken()->getRoles()) {
            $menu->addChild($this->tokenStorage->getToken()->getUsername(), ['route' => 'homepage']);
            $menu->addChild('Logout', [
                'uri' => '/logout',
                'attributes' => [
                    'class' => 'usermenu-last'
                ],
            ]);
        } else {
            $menu->addChild('Login', ['uri' => '/login']);
            $menu->addChild('Register', [
                'uri' => '/register',
                'attributes' => [
                    'class' => 'usermenu-last'
                ],
            ]);
        }

        return $menu;
    }

}