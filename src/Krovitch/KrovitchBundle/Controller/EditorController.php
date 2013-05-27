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
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editMapAction()
    {
        $map = new Map();
        $route = 'createMap';
        $parameters = array();

        if ($id = $this->getRequest()->get('id', 0)) {
            $map = $this->getManager('Map')->find($id);
            $route = 'editMap';
            $parameters = array('id' => $id);
        }
        $this->redirect404Unless($map, sprintf('Map not found (id:%s)', $id));
        $form = $this->createForm(new MapType(), $map);
        // handle form submission
        if ($this->getRequest()->isMethod('post')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                // saving map record in database
                $this->getManager('Map')->save($map);
                // informs user save success
                $this->setMessage('editor.map.saveSuccess', array('%map%' => $map->getName()));
                // redirect to list
                return $this->redirect('@editor');
            }
        }
        return array('form' => $form->createView(), 'route' => array('name' => $route, 'parameters' => $parameters));
    }

    /**
     * @Route("/map/delete/{id}", name="deleteMap", requirements={"id" = "\d+"})
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function deleteAction()
    {
        $map = $this->getManager('Map')->find($id = $this->getRequest()->get('id'));
        $this->redirect404Unless($map, sprintf('Map not found (id:%s) ', $id));

        if ($map) {
            $this->getManager('Map')->delete($map);
        }
        return $this->redirect('@editor');
    }


    protected function validParametersForAction($id, $action)
    {
        if (in_array($action, array('edit', 'delete')) && !$id) {
            throw $this->createNotFoundException(sprintf('Edit or delete action required a "id" parameter.'));
        }

    }
}