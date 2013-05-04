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
     *
     * @return array
     */
    public function indexAction()
    {
        // TODO make a map chooser
        $map = $this->getManager('Map')->findAll()[0];
        // get map json content for the view
        $mapJson = $this->getManager('Map')->load($map);

        return array('map' => $mapJson);
    }

    /**
     * @Route("/save", name="mapSave")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    public function saveAction(Request $request)
    {
        $mapData = json_decode($request->get('data'));
        $map = $this->getManager('Map')->find($request->get('id'));
        $this->redirect404Unless($map, 'Unable to find map with id '.$this->getRequest()->get('id'));
        // save map in database
        $this->getManager('Map')->setData($mapData);
        $this->getManager('Map')->save($map);

        return new Response('0');
    }
}