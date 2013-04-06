<?php

namespace Krovitch\KrovitchBundle\Controller;

use Krovitch\KrovitchBundle\Entity\Hero;
use Krovitch\KrovitchBundle\Entity\Map;
use Krovitch\KrovitchBundle\Form\HeroType;
use Krovitch\KrovitchBundle\Form\MapType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $maps = $this->getManager('Map')->findAll();

        return array('heroes' => $heroes, 'maps' => $maps);
    }

    /**
     * @Route("/hero/create", name="createHero")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function createHeroAction()
    {
        $hero = new Hero();
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
        $hero = $this->getManager('Hero')->find($request->get('id'));
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

    /**
     * @Route("/map/create", name="createMap")
     * @Route("/map/edit/{id}", name="editMap", requirements={"id" = "\d+"})
     * @Route("/map/delete/{id}", name="deleteMap", requirements={"id" = "\d+"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editMapAction()
    {
        $request = $this->getRequest();
        $id = $request->get('id');
        $map = new Map();
        $route = array('name' => 'createMap', 'parameters' => array());

        // is new ?
        if ($id) {
            // load existing map
            $map = $this->getManager('Map')->find($id);
            $route = array('name' => 'editMap', 'parameters' => array('id' => $id));
        }
        $form = $this->createForm(new MapType(), $map);

        if ($request->isMethod('post')) {
            $form->bind($request);

            if ($form->isValid()) {
                $this->getManager('Hero')->save($map);
                $this->setMessage('editor.map.saveSuccess', array('%map%' => $map->getName()));
            }
        }
        return array('form' => $form->createView(), 'route' => $route);
    }


    protected function validParametersForAction($id, $action)
    {
        if (in_array($action, array('edit', 'delete')) && !$id) {
            throw $this->createNotFoundException(sprintf('Edit or delete action required a "id" parameter.'));
        }

    }
}