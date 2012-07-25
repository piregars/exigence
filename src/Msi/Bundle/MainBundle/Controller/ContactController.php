<?php

namespace Msi\Bundle\MainBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Msi\Bundle\MainBundle\Form\Type\ContactFormType;

class ContactController extends ContainerAware
{
    /**
     * @Route("/{_locale}/contact/new")
     */
    public function contactAction()
    {
        $form = $this->container->get('form.factory')->create(new ContactFormType(), null);
        $formHandler = $this->container->get('msi_main.contact.form.handler');

        $process = $formHandler->process($form);

        if ($process) {
            $url = $this->container->get('router')->generate('homepage', array('_locale' => 'fr'));

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('MsiMainBundle:Contact:contact_form.html.twig', array('form' => $form->createView()));
    }
}
