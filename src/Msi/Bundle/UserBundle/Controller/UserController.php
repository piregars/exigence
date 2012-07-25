<?php

namespace Msi\Bundle\NewsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends ContainerAware
{
    /**
     * @Route("/team/list", defaults={"_locale" = "en"})
     * @Template()
     */
    public function listAction()
    {
        $users = $this->container->get('msi_user.user_manager')->findBy(array('a.team' => true), array(), array('a.position' => 'ASC'))->getQuery()->execute();

        return array('users' => $users);
    }
}
