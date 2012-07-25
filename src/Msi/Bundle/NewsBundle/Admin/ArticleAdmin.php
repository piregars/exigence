<?php

namespace Msi\Bundle\NewsBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class ArticleAdmin extends Admin
{
    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('published', 'boolean')
            ->add('title')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('title')
            ->add('user', 'entity', array('class' => 'MsiUserBundle:User'))
            ->add('body', 'textarea', array('attr' => array('class' => 'tinymce')))
        ;
    }
}
