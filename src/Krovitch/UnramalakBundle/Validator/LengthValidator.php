<?php
//
//namespace Krovitch\UnramalakBundle\Validator;
//
//use Symfony\Component\Validator\Constraint;
//use Symfony\Component\Validator\ConstraintValidator;
//use Symfony\Component\Validator\Exception\UnexpectedTypeException;
//
//class LengthValidator extends ConstraintValidator
//{
//  /**
//   * Return true if $value is between $constraint minLength and maxLength. Return false otherwise
//   * @param mixed $value
//   * @param \Symfony\Component\Validator\Constraint $constraint
//   * @return bool
//   * @throws \Symfony\Component\Validator\Exception\UnexpectedTypeException
//   */
//  public function isValid($value, Constraint $constraint)
//  {
//    if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
//      throw new UnexpectedTypeException($value, 'string');
//    }
//    $value = (string) $value;
//    $isValid = true;
//
//    // validation : length must between min length and max length
//    if ($constraint->minLength <= strlen($value) || $constraint->maxLength >= strlen($value)) {
//      $this->setMessage($constraint->message, array('{{ minLength }}' => $constraint->minLength, '{{ maxLength }}' => $constraint->maxLength));
//      $isValid = false;
//    }
//    return $isValid;
//  }
//}