<?php

namespace Krovitch\KrovitchBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact extends Entity
{
  /**
   * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
   * @Assert\MinLength(limit=3, message="Vous devez saisir au moins {limit} caractères")
   */
  public $name;

  /**
   * @Assert\MinLength(3)
   * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
   */
  public $password;

  /**
   * @Assert\MinLength(limit=3, message="Vous devez saisir au moins {limit} caractères")
   * @Assert\Email(message="Ce champ doit être un email valide")
   * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
   */
  public $email;

  public function getName()
  {
    return $this->name;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getEmail()
  {
    return $this->email;
  }
}
