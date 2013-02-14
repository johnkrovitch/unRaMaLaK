<?php

namespace Krovitch\KrovitchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/map")
 */
class MapController extends BaseController
{
    /**
     * @Route("/", name="map")
     * @Template()
     * @Secure(roles="ROLE_USER")
     *
     * @return array
     */
    public function indexAction()
    {
        $map = $this->getManager('Map')->find(1);

        return array('map' => $map->serialize());
    }

    /**
     * @Route("/save", name="mapSave")
     * @Secure(roles="ROLE_ADMIN")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    public function saveAction(Request $request)
    {
        $map = $this->getManager('Map')->find(1);
        $this->redirect404Unless($map, 'Unable to find map with id '.$this->getRequest()->get('id'));
        // saving map content
        $map->setContent($request->get('data'));
        $this->getManager('Map')->save($map);

        return new Response('0');
    }
}