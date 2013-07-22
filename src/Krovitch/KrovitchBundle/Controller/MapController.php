<?php

namespace Krovitch\KrovitchBundle\Controller;
use Krovitch\BaseBundle\Controller\BaseController;
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
     * @return array
     */
    public function indexAction()
    {
        // TODO make a map chooser
        $maps = $this->getManager('Map')->findAll();

        $this->redirect404Unless(count($maps), 'What the hell ?!!! Not map found !');



        return array('maps' => $maps);
    }

    /**
     * @Route("/load", name="mapLoad")
     */
    public function loadMapAction()
    {
        // TODO check permissions
        $id = $this->getRequest()->get('id');
        $map = $this->getManager()->find($id);
        $this->redirect404Unless($map, 'Map not found (id: ' . $id . ')');
        // get map json content for the view
        $mapJson = $this->getManager('Map')->load($map);

        return $this->renderJson($mapJson);
    }

    protected function renderJson($content)
    {
        $response = new Response();
        $response->setContent($content);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
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