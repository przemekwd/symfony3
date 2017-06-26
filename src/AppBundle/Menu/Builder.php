<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        /*$em = $this->container->get('doctrine')->getManager();
        $games = $em->getRepository('GamesBundle:Game')->findMostRecent();*/

        $menu = $factory->createItem('root');
        $menu->addChild('Home', ['route' => 'homepage']);
        $menu->addChild('Games', ['route' => 'game_index']);
        $menu->addChild('Developers', ['route' => 'developer_index']);

        return $menu;
    }

}