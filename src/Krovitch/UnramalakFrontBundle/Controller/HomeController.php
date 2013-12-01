<?php

namespace Krovitch\UnramalakFrontBundle\Controller;

use FOS\UserBundle\Model\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\KrovitchUserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Template()
     */
    public function registerAction(Request $request)
    {
        /** @var UserManager $userManager */
        $userManager = $this->get('fos_user.user_manager');
        /** @var User $user */
        $user = $userManager->createUser();
        $form = $this->createForm('user_type', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);
            // redirect to hero creation
            return $this->redirect('@hero.create');
        }

        return ['form' => $form->createView()];
    }
}
