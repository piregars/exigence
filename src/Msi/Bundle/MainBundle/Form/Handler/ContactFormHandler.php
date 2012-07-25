<?php

namespace Msi\Bundle\MainBundle\Form\Handler;

class ContactFormHandler
{
    protected $request;
    protected $templating;
    protected $mailer;

    public function __construct($request, $templating, $mailer)
    {
        $this->request = $request;
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    public function process($form)
    {
        if ($this->request->getMethod() === 'POST') {
            $form->bindRequest($this->request);

            if ($form->isValid()) {
                $this->onSuccess();

                return true;
            }
        }

        return false;
    }

    protected function onSuccess()
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Contact Form')
            ->setFrom('noreply@groupemsi.com')
            ->setTo('fangers@groupemsi.com')
            ->setBody($this->templating->render('MsiMainBundle:Contact:email.txt.twig', array('form' => $this->request->request->get('msi_main_contact'))))
        ;
        $this->mailer->send($message);
    }
}
