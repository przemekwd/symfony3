<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'nav navbar-nav',
            ],
        ]);
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Games', ['route' => 'game_index']);
        $menu->addChild('Developers', ['route' => 'developer_index']);

        return $menu;
    }

}