<?php

namespace Krovitch\KrovitchBundle\Manager;

class ContentManager extends BaseManager
{
  protected function getRepository($repository_name = null)
  {
    return parent::getRepository($repository_name ?: 'KrovitchBundle:Content');
  }


}