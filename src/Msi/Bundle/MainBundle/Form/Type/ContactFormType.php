<?php

namespace Msi\Bundle\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('required' => true))
            ->add('email', 'email', array('required' => true))
            ->add('message', 'textarea', array('attr' => array('style' => 'width: 350px;'), 'required' => true))
        ;
    }

    public function getName()
    {
        return 'msi_main_contact';
    }
}
