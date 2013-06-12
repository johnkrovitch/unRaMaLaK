<?php

namespace Krovitch\KrovitchBundle\Manager;

use Krovitch\BaseBundle\Manager\BaseManager;

class ContentManager extends BaseManager
{
  protected function getRepository($repository_name = null)
  {
    return parent::getRepository($repository_name ?: 'KrovitchBundle:Content');
  }
}