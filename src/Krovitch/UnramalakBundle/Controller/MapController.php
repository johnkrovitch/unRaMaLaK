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
     * List all maps
     *
     * @Template()
     */
    public function indexAction()
    {
        $maps = $this->get('unramalak.manager.map')->findAll();

        return ['maps' => $maps];
    }

    /**
     * Create a new map
     *
     * @Template("KrovitchUnramalakBundle:Map:edit.html.twig")
     */
    public function createAction()
    {
        $map = new Map();

        return $this->editAction($map);
    }

    /**
     * Edit existing maps
     *
     * @ParamConverter("map", class="Krovitch\UnramalakBundle\Entity\Map")
     * @Template("KrovitchUnramalakBundle:Map:edit.html.twig")
     */
    public function editAction(Map $map)
    {
        $form = $this->createForm('map', $map);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $this->get('unramalak.manager.map')->save($map);
        }
        return ['form' => $form->createView()];
    }

    /**
     * Delete map
     *
     * @ParamConverter("map", class="Krovitch\UnramalakBundle\Entity\Map")
     * @Template()
     */
    public function deleteAction(Map $map)
    {
        $this->get('unramalak.manager.map')->delete($map);

        return $this->indexAction();
    }

    /**
     * @ParamConverter("map", class="Krovitch\UnramalakBundle\Entity\Map")
     * @Template()
     */
    public function testAction(Map $map)
    {
        // get map json content for the view
        $mapContext = $this->getMapManager()->load($map);

        return array('mapContext' => $mapContext, 'title' => $map->getName());
    }

    /**
     * Display the map
     * @Route("/display/{id}", name="map-display")
     * @Template()
     */
    public function displayAction($id)
    {
//        // TODO check permissions
//        $map = $this->getManager()->find($id);
//        $this->redirect404Unless($map, 'Map not found (id: ' . $id . ')');
//        // get map json content for the view
//        $mapJson = $this->getManager('Map')->load($map);
//        // get map textures
//        $textures = $this->getManager('Map')->loadTextures($map);
//
//        return array('data' => $mapJson, 'title' => $map->getName(), 'textures' => $textures);
    }

    /**
     * Save map into database
     *
     * @return Response
     */
    public function saveAction()
    {
        $data = $this->getRequest()->get('data');
        $this->getMapManager()->saveMap($data);

        return new Response('0');
    }
}