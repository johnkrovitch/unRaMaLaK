<?php

namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krovitch\UnramalakBundle\Manager\MapManager;

class AdminController extends BaseController
{
    /**
     * Admin dashboard
     *
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        $maps = $this->getManager('Map')->findAll();

        return array('maps' => $maps);
    }

    /**
     * @Template()
     * @param $action
     * @param $entity
     * @param $id
     */
    public function executeAction($action, $entity, $id)
    {
        if ($entity == 'map') {


        }
    }

    protected function handleMap($action, $id)
    {
        /** @var MapManager $manager */
        $manager = $this->getManager('Map');
        $map = $manager->find($id);
        $this->redirect404Unless($map, 'Unable to find map (id="'.$id.'")');

        if ($action == 'regenerate') {
            $manager->regenerate($map);
            $this->setMessage('Map was regenerated succesfully !');
        }
    }
}
