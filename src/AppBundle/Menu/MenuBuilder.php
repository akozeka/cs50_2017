<?php

namespace AppBundle\Menu;

use AppBundle\Entity\Office;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function defaultMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'homepage'));
        $menu->addChild('Register', array('route' => 'register'));

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'user_home'));
        $menu->addChild('Edit profile', array('route' => 'user_edit'));

        return $menu;
    }

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', array('route' => 'user_home'));

        return $menu;
    }
}
