<?php

namespace Krovitch\KrovitchBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/editor")
 */
class EditorController extends BaseController
{
    /**
     * @Route("/", name="editor")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/createHero", name="createHero")
     * @Template()
     */
    public function createHeroAction()
    {
        $form = $this->createForm('Hero');
        return array();
    }
}