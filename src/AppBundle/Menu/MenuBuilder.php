<?php

namespace AppBundle\Menu;

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
        $menu->addChild('Home', ['route' => 'home']);
        $menu->addChild('Register', ['route' => 'register']);
        $menu->addChild('Offices', ['route' => 'office'])->setAttribute('dropdown', true);

        $menu['Offices']->addChild('Offices map', ['route' => 'office_map']);
        $menu['Offices']->addChild('Offices list', ['route' => 'office_list']);

        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', ['route' => 'user_home']);
        $menu->addChild('Offices', ['route' => 'office_list']);

        return $menu;
    }

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->addChild('Home', ['route' => 'admin_home']);
        $menu->addChild('Offices', ['route' => 'office_list'])->setAttribute('dropdown', true); // NB

        $menu['Offices']->addChild('Office categories', ['route' => 'admin_office_category_list']);
        $menu['Offices']->addChild('Offices', ['route' => 'office_list']);

        return $menu;
    }
}
