<?php

namespace Msi\Bundle\UserBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TeamController extends ContainerAware
{
    /**
     * @Route("/team/list", defaults={"_locale" = "en"})
     * @Template()
     */
    public function listAction()
    {
        $teams = $this->container->get('msi_user.team_manager')->findBy(array('a.enabled' => true), array(), array('a.position' => 'ASC'))->getQuery()->execute();

        return array('teams' => $teams);
    }

    /**
     * @Route("/team/{slug}", defaults={"_locale" = "en"})
     * @Template()
     */
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');

        $team = $this->container->get('msi_user.team_manager')->findBy(array('a.enabled' => true, 'a.slug' => $slug), array(), array('a.position' => 'ASC'))->getQuery()->getSingleResult();

        return array('team' => $team);
    }
}
