<?php

namespace Krovitch\KrovitchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints as Assert;

class ContentType extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('title', 'text');
    $builder->add('content', 'textarea');
  }

  function getName()
  {
    return 'content';
  }
}