<?php


namespace Krovitch\UnramalakFrontBundle\Controller;

use Krovitch\UnramalakBundle\Entity\Hero;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeorgetteParty\BaseBundle\Controller\BaseController;

class HeroController extends BaseController
{
    /**
     * @Template
     */
    public function createAction()
    {
        $hero = new Hero();
        $attributes = $this->getManager('Attribute')->findAll();

        $form = $this->createForm('hero_type', $hero, [
            'available_attributes' => $attributes
        ]);

        return ['form' => $form->createView()];
    }
} 