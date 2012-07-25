<?php

namespace Msi\Bundle\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $root = $this->container->get('msi_menu.root_manager')->findRootById(1);

        $menu = $factory->createFromNode($root);

        foreach ($menu as $m) {
            if ($this->container->get('request')->getPathInfo() === $m->getUri()) {
                $m->setCurrent(true);
            }
        }

        return $menu;
    }
}
