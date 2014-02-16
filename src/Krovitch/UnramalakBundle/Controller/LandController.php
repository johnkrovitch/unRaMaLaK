<?php


namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\UnramalakBundle\Entity\Land;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class LandController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $lands = $this->get('unramalak.manager.land')->findAll();

        return ['lands' => $lands];
    }

    /**
     * @Template("KrovitchUnramalakBundle:Land:create.html.twig")
     */
    public function createAction()
    {
        $land = new Land();
        $form = $this->createForm('land', $land);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $this->get('unramalak.manager.land')->save($land);
        }
        return ['form' => $form->createView()];
    }
} 