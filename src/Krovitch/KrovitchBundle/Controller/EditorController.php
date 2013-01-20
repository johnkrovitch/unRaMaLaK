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
     * @Route("/hero/create", name="createHero")
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
                $this->setMessage('Hero %hero% was successfully created !', array('%hero%' => $hero->getName()));

                return $this->redirect('@editor');
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/hero/edit/{id}", name="editHero")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editHeroAction()
    {
        $request = $this->getRequest();
        $hero  = $this->getManager('Hero')->find($request->get('id'));
        $form = $this->createForm(new HeroType(), $hero);

        if ($request->isMethod('post')) {
            $form->bind($request);

            if ($form->isValid()) {
                // set upload dir before saving hero
                $hero->setUploadDir($this->getConfig('krovitch.unit.upload_dir'));
                $this->getManager('Hero')->save($hero);
                $this->setMessage('Hero %hero% was successfully created !', array('%hero%' => $hero->getName()));

                return $this->redirect('@editor');
            }
        }
        return array('form' => $form->createView(), 'heroId' => $hero->getId());
    }

    /**
     * @Route("/hero/delete/{id}", name="deleteHero")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function deleteHeroAction()
    {
        $id = $this->getRequest()->get('id');
        $hero = $this->getManager('Hero')->find($id);

        if (!$hero) {
            throw $this->createNotFoundException(sprintf('Hero with id %s not found.', $id));
        }
        $this->getManager('Hero')->delete($hero);
        $this->setMessage('Hero %hero% was successfully deleted.', array('%hero%' => $hero->getName()));

        return $this->redirect('@editor');
    }
}