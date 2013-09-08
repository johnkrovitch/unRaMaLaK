<?php

namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/test")
 */
class TestsController extends BaseController
{
    /**
     * @Route("/", name="tests")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        return array();
    }
}
