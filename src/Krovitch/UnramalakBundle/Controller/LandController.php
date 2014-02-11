<?php


namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class LandController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $lands = $this->get('unramalak.manager.land_manager')->findAll();

        return array('lands' => $lands);
    }
} 