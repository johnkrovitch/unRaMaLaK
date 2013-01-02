<?php

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HeroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('email', 'email');
        $builder->add('password', 'password');

        return $builder;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'Hero';
    }
}