<?php

namespace Krovitch\KrovitchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krovitch\KrovitchBundle\Entity\Contact;

/**
 * @Route("/map")
 */
class MapController extends Controller
{
  /**
   * @Route("/", name="_map")
   * @Template()
   * @return array
   */
  public function indexAction()
  {
    return array();
  }
}