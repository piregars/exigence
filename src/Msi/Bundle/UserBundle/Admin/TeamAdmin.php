<?php

namespace Msi\Bundle\UserBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class TeamAdmin extends Admin
{
    public function buildTable($builder)
    {
        $builder
            ->add('id')
            ->add('enabled', 'boolean')
            ->add('name')
            ->add('updatedAt', 'date')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $builder
            ->add('name')
        ;
    }
}
