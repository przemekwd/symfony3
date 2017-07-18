<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Translation\TranslatorInterface;

class MenuBuilder
{
    private $factory;
    private $tokenStorage;
    private $translator;

    public function __construct(FactoryInterface $factory, TokenStorage $tokenStorage, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->tokenStorage = $tokenStorage;
        $this->translator = $translator;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav navbar-left',
            ],
        ]);
        $menu->addChild($this->translator->trans('menu.home', [], 'GamesBundle'), ['route' => 'homepage']);
        $menu->addChild($this->translator->trans('menu.games', [], 'GamesBundle'), ['route' => 'game_index']);
        $menu->addChild($this->translator->trans('menu.developers', [], 'GamesBundle'), ['route' => 'developer_index']);

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
            $menu->addChild($this->translator->trans('layout.logout', [], 'FOSUserBundle'), [
                'uri' => '/logout',
                'attributes' => [
                    'class' => 'usermenu-last'
                ],
            ]);
        } else {
            $menu->addChild($this->translator->trans('security.login.submit', [], 'FOSUserBundle'), ['uri' => '/login']);
            $menu->addChild($this->translator->trans('registration.submit', [], 'FOSUserBundle'), [
                'uri' => '/register',
                'attributes' => [
                    'class' => 'usermenu-last'
                ],
            ]);
        }

        return $menu;
    }

}