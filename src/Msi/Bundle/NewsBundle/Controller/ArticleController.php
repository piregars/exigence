<?php

namespace Msi\Bundle\NewsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArticleController extends ContainerAware
{
    /**
     * @Route("/news/list", defaults={"_locale" = "en"})
     * @Template()
     */
    public function listAction()
    {
        $articles = $this->container->get('msi_news.article_manager')->findBy(array('a.published' => true), array(), array('a.createdAt' => 'DESC'))->getQuery()->execute();

        return array('articles' => $articles);
    }

    /**
     * @Route("/news/{slug}", defaults={"_locale" = "en"})
     * @Template()
     */
    public function showAction()
    {
        $slug = $this->container->get('request')->attributes->get('slug');

        $article = $this->container->get('msi_news.article_manager')->findBy(array('a.published' => true, 'a.slug' => $slug))->getQuery()->getSingleResult();

        return array('article' => $article);
    }
}
