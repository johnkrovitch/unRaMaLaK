<?php


namespace Krovitch\UnramalakFrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('email', 'email', [
            'label' => 'Email',
            'attr' => ['placeholder' => 'Saisissez un email...']
        ]);
        $builder->add('password', 'repetead', [
            'type' => 'password',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password']
        ],array(

        ));

    }

    public function getName()
    {
        return 'unramalak_user';
    }
}