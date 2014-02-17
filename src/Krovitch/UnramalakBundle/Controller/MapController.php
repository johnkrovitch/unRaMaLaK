<?php

namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\UnramalakBundle\Behavior\HasMapManager;
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
    use HasMapManager;

    /**
     * Display the map chooser
     * @Route("/", name="map")
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $maps = $this->getMapManager()->findAll();
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

    /**
     * Save map into database
     *
     * @return Response
     */
    public function saveAction()
    {
        $data = $this->getRequest()->get('data');
        $this->get('unramalak.manager.map')->saveMap($data);

        return new Response('0');
    }

    /**
     * @Template()
     */
    public function testAction(Map $map)
    {
        // get map json content for the view
        $mapContext = $this->getMapManager()->load($map);

        return array('mapContext' => $mapContext, 'title' => $map->getName());
    }
}