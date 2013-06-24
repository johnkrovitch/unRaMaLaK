<?php

namespace Krovitch\KrovitchBundle\Controller;

use Krovitch\BaseBundle\Controller\BaseController;
use Krovitch\KrovitchBundle\Entity\Hero;
use Krovitch\KrovitchBundle\Entity\Map;
use Krovitch\KrovitchBundle\Entity\Media;
use Krovitch\KrovitchBundle\Form\HeroType;
use Krovitch\KrovitchBundle\Form\MapType;
use Krovitch\KrovitchBundle\Form\MediaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * @Route("/media")
 */
class MediaController extends BaseController
{
    /**
     * @Route("/", name="media")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $medias = $this->getManager('Media')->findAll();

        return array('medias' => $medias);
    }

    /**
     * @Route("/media/create", name="createMedia")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function createMediaAction()
    {
        $media = new Media();
        $request = $this->getRequest();
        $form = $this->createForm(new MediaType(), $media);

        if ($request->isMethod('post')) {
            $form->submit($request);

            if ($form->isValid()) {
                //$media->setFile($request->getFile)
                //$hero->setLife(500);
                $this->getManager('Hero')->save($media);
                $this->setMessage('Hero %hero% was successfully created !', array('%hero%' => $hero->getName()));

                return $this->redirect('@editor');
            }
        }
        return array('form' => $form->createView());
    }

   protected function validParametersForAction($id, $action)
    {
        if (in_array($action, array('edit', 'delete')) && !$id) {
            throw $this->createNotFoundException(sprintf('Edit or delete action required a "id" parameter.'));
        }

    }
}