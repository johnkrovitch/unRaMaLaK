<?php


namespace Krovitch\KrovitchUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder->add('email', 'email', [
            'label' => 'Votre email',
            'attr' => ['placeholder' => 'Saisissez un email...']
        ]);
        $builder->add('plainPassword', 'password', [
            'label' => 'Mot de passe',
            'attr' => [
                'class' => 'password-field',
                'placeholder' => 'Saisissez un VRAI mot de passe...'
            ]
        ]);
        $builder->add('username', 'text', [
            'label' => 'Votre nom',
            'attr' => ['placeholder' => 'Choisissez un nom pas trop débile...']
        ]);
    }

    public function getName()
    {
        return 'user_type';
    }
}