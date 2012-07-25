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

        foreach ($menu as $m) {
            if ($pathInfo === $m->getUri() || preg_match('@^'.$pathInfo.'@', $m->getUri())) {
                $m->setCurrent(true);
            }
        }

        return $menu;
    }
}
