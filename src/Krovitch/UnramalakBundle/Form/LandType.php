<?php

namespace Krovitch\UnramalakBundle\Form;

use Krovitch\UnramalakBundle\Entity\Land;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'label' => 'unramalak.land.name',
            'attr' => ['placeholder' => 'unramalak.land.name.placeholder']
        ]);
        $builder->add('type', 'choice', [
            'label' => 'unramalak.land.type',
            'choices' => Land::getLandTypes()
        ]);
    }

    public function getName()
    {
        return 'land';
    }

    public function getParent()
    {
        return 'base';
    }
}