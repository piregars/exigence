<?php

namespace Msi\Bundle\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $pathInfo = $this->container->get('request')->getPathInfo();
        $root = $this->container->get('msi_menu.root_manager')->findRootById(1);

        $menu = $factory->createFromNode($root);

        foreach ($menu as $child) {
            if ($pathInfo === $child->getUri() || ($child->getUri() !== '/' && preg_match('@^'.$child->getUri().'@', $pathInfo))) {
                $child->setCurrent(true);
            }
        }

        return $menu;
    }
}
