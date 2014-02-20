<?php

namespace Krovitch\UnramalakBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;


class MapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');
        $builder->add('name', 'text');
        $builder->add('description', 'textarea');
        $builder->add('width', 'integer');
        $builder->add('height', 'integer');
        $builder->add('cellPadding', 'integer');

        return $builder;
    }

    public function getName()
    {
        return 'map';
    }

    public function getParent()
    {
        return 'base';
    }
}