<?php

namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WidgetController extends BaseController
{
    /**
     * @Template()
     */
    public function listAction()
    {
        return array();
    }
}