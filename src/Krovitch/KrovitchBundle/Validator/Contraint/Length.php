<?php

namespace Krovitch\KrovitchBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 *
 * @api
 */
class Length extends Constraint
{
  public $message = 'This value should have beetween {{ minLength }} and {{ maxLength }} characters';
  public $minLength = 0;
  public $maxLength = 255;
}