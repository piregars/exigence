<?php

namespace Msi\Bundle\UserBundle\Admin;

use Msi\Bundle\AdminBundle\Admin\Admin;

class UserAdmin extends Admin
{
    public function configure()
    {
        $this->setSearchFields(array('username'));
    }

    public function buildTable($builder)
    {
        $builder
            ->add('username', 'text', array('edit' => true))
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $roles = array();
        foreach ($this->adminServiceIds as $serviceId) {
            $roles['ROLE_'.strtoupper($serviceId).'_LIST'] = strtoupper($serviceId).'_READ';
            $roles['ROLE_'.strtoupper($serviceId).'_CREATE'] = strtoupper($serviceId).'_CREATE';
            $roles['ROLE_'.strtoupper($serviceId).'_UPDATE'] = strtoupper($serviceId).'_UPDATE';
            $roles['ROLE_'.strtoupper($serviceId).'_DELETE'] = strtoupper($serviceId).'_DELETE';
        }

        $roles['ROLE_ADMIN'] = 'ROLE_ADMIN';

        $builder
            ->add('username')
            ->add('email')
            ->add('avatarFile', 'file', array('label' => 'Avatar'))
            ->add('location')
            ->add('bio', 'textarea')
            ->add('roles', 'choice', array(
                'choices' => $roles,
                'expanded' => false,
                'multiple' => true,
                'required' => false,
            ))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'first_name' => 'Password',
                'second_name' => 'Confirm password',
                'required' => preg_replace(array('#^[a-z]+_[a-z]+_[a-z]+_#'), array(''), $this->container->get('request')->attributes->get('_route')) === 'edit' ? false : true,
            ))
        ;
    }
}
