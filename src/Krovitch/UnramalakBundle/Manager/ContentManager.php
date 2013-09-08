<?php

namespace Krovitch\UnramalakBundle\Manager;
use GeorgetteParty\BaseBundle\Manager\BaseManager;

class ContentManager extends BaseManager
{
    protected function getRepository($repository_name = null)
    {
        return parent::getRepository($repository_name ? : 'UnramalakBundle:Content');
    }
}