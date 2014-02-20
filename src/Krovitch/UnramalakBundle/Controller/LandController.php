<?php


namespace Krovitch\UnramalakBundle\Controller;

use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\UnramalakBundle\Entity\Land;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class LandController extends BaseController
{
    /**
     * List all lands
     *
     * @Template()
     */
    public function indexAction()
    {
        $lands = $this->get('unramalak.manager.land')->findAll();

        return ['lands' => $lands];
    }

    /**
     * Create a new land
     *
     * @Template("KrovitchUnramalakBundle:Land:edit.html.twig")
     */
    public function createAction()
    {
        $land = new Land();

        return $this->editAction($land);
    }

    /**
     * Edit existing lands
     *
     * @ParamConverter("land", class="Krovitch\UnramalakBundle\Entity\Land")
     * @Template("KrovitchUnramalakBundle:Land:edit.html.twig")
     */
    public function editAction(Land $land)
    {
        $form = $this->createForm('land', $land);
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $this->get('unramalak.manager.land')->save($land);
        }
        return ['form' => $form->createView()];
    }
} 