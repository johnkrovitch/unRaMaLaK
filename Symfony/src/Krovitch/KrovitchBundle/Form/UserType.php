<?php

namespace Krovitch\KrovitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints as Assert;


class UserType extends AbstractType
{
  /**
   * @Assert\MinLength(
   *   limit=3,
   *   message="Vous devez saisir au moins 3 caractères"
   * )
   */
  public $name;

  public $email;

  public $password;

  public function buildForm(FormBuilder $builder, array $options)
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
  function getName()
  {
    return $this->name;
  }
}