<?php

namespace Krovitch\KrovitchBundle\Controller;

use Krovitch\KrovitchBundle\Entity\Hero;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Krovitch\KrovitchBundle\Form\HeroType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/editor")
 */
class EditorController extends BaseController
{
    /**
     * @Route("/", name="editor")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $heroes = $this->getManager('Hero')->findAll();

        return array('heroes' => $heroes);
    }

    /**
     * @Route("/createHero", name="createHero")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function createHeroAction()
    {
        $hero  = new Hero();
        $request = $this->getRequest();
        $form = $this->createForm(new HeroType(), $hero);

        if ($request->isMethod('post')) {
            $form->bind($request);

            if ($form->isValid()) {
                $hero->setLevel(0);
                $hero->setLife(500);
                $this->getManager('Hero')->save($hero);

                $this->forward('editor');
            }
        }
        return array('form' => $form->createView());
    }
}