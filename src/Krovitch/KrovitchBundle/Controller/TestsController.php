<?php

namespace Krovitch\KrovitchBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krovitch\KrovitchBundle\Entity\Contact;

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
