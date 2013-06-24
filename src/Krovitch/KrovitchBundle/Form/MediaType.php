<?php

namespace Krovitch\KrovitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file');
        $builder->add('editor.save', 'submit');
        $builder->add('editor.cancel', 'reset');
        //$builder->add('avatar', 'file', array('data_class' => null));
        //$builder->add('race', 'entity', array('class' => 'KrovitchBundle:Race', 'property' => 'name'));



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