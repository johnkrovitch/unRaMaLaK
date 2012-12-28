<?php

namespace Krovitch\KrovitchBundle\Entity;

class Entity
{
  public function toArray()
  {
    print_r(get_object_vars($this));
    return get_object_vars($this);
  }
}