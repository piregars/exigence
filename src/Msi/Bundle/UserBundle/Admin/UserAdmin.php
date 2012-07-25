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
            ->add('id')
            ->add('avatar', 'image')
            ->add('username', 'text', array('edit' => true))
            ->add('nickname')
            ->add('team')
            ->add('', 'action')
        ;
    }

    public function buildForm($builder)
    {
        $roles = array();
        $isAdmin = $this->container->get('security.context')->isGranted('ROLE_ADMIN');
        $isSuperAdmin = $this->container->get('security.context')->isGranted('ROLE_SUPER_ADMIN');

        if ($isAdmin) {
            foreach ($this->adminServiceIds as $serviceId) {
                $roles['ROLE_'.strtoupper($serviceId).'_READ'] = strtoupper($serviceId).'_READ';
                $roles['ROLE_'.strtoupper($serviceId).'_CREATE'] = strtoupper($serviceId).'_CREATE';
                $roles['ROLE_'.strtoupper($serviceId).'_UPDATE'] = strtoupper($serviceId).'_UPDATE';
                $roles['ROLE_'.strtoupper($serviceId).'_DELETE'] = strtoupper($serviceId).'_DELETE';
            }
            $roles['ROLE_MANAGER'] = 'ROLE_MANAGER';
        }

        if ($isSuperAdmin) {
            $roles['ROLE_ADMIN'] = 'ROLE_ADMIN';
        }

        $builder
            ->add('username')
            ->add('team', 'entity', array('empty_value' => 'Select...', 'class' => 'MsiUserBundle:Team'))
            ->add('email')
            ->add('nickname')
            ->add('avatarFile', 'file', array('label' => 'Avatar'))
            ->add('location')
            ->add('bio', 'textarea')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'first_name' => 'Password',
                'second_name' => 'Confirm password',
            ))
        ;

        if ($isAdmin) {
            $builder->
                add('roles', 'choice', array(
                    'choices' => $roles,
                    'expanded' => false,
                    'multiple' => true,
                    'required' => false,
                ))
            ;
        }
    }
}
