<?php

namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\UnramalakBundle\Entity\Map;
use Krovitch\UnramalakBundle\Manager\MapManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;

/**
 * @Route("/map")
 */
class MapController extends BaseController
{
    /**
     * Display the map chooser
     * @Route("/", name="map")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $maps = $this->getManager('Map')->findAll();
        $this->redirect404Unless(count($maps), 'What the hell ?!!! Not map found !');

        return array('maps' => $maps);
    }

    /**
     * Display the map
     * @Route("/display/{id}", name="map-display")
     * @Template()
     */
    public function displayAction($id)
    {
        // TODO check permissions
        $map = $this->getManager()->find($id);
        $this->redirect404Unless($map, 'Map not found (id: ' . $id . ')');
        // get map json content for the view
        $mapJson = $this->getManager('Map')->load($map);
        // get map textures
        $textures = $this->getManager('Map')->loadTextures($map);

        return array('data' => $mapJson, 'title' => $map->getName(), 'textures' => $textures);
    }


    public function saveAction()
    {
        $data = json_decode($this->getRequest()->get('data'), false);

        if (!$data || !$data->profile || !$data->profile->id) {
            throw new InvalidParameterException('Invalid map profile');
        }
        $map = $this->getManager('Map')->find($data->profile->id);
        $this->getManager('Map')->saveMap($map, $data);

        return new Response('0');

        // TODO security
        $mapData = json_decode($request->get('data'));
        $map = $this->getManager('Map')->find($request->get('id'));
        $this->redirect404Unless($map, 'Unable to find map with id ' . $this->getRequest()->get('id'));
        // save map in database
        $this->getManager('Map')->setData($mapData);
        $this->getManager('Map')->save($map);

        return new Response('0');
    }

    /**
     * @ParamConverter("map", class="Krovitch\UnramalakBundle\Entity\Map")
     * @Template()
     */
    public function testAction(Map $map)
    {
        // get map json content for the view
        $mapJson = $this->getManager('Map')->load($map);
        // get map textures
        $textures = $this->getManager('Map')->loadTextures($map);

        return array('data' => $mapJson, 'title' => $map->getName(), 'textures' => $textures);
    }

    /**
     * @ParamConverter("map", class="Krovitch\UnramalakBundle\Entity\Map")
     */
    public function regenerateAction(Map $map)
    {
        $this->getManager('Map')->regenerate($map);
        $this->setMessage('Map was regenerated succesfully !');

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}