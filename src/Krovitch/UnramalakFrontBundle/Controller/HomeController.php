<?php

namespace Krovitch\UnramalakFrontBundle\Controller;

use FOS\UserBundle\Model\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use GeorgetteParty\BaseBundle\Controller\BaseController;
use Krovitch\KrovitchUserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class HomeController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // if the player has no hero, we should create one
        if ($this->getUser() && !$this->getUser()->hasArmies()) {
            $this->setMessage('unramalak.hero.redirectForCreation');
            return $this->redirect('@unramalak.hero.create');
        }
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
            $this->logUser($user);
            // redirect to hero creation
            return $this->redirect('@unramalak.hero.create');
        }

        return ['form' => $form->createView()];
    }

    public function logUser(User $user)
    {
        $token = new UsernamePasswordToken($user, null, "your_firewall_name", $user->getRoles());
        $this->get("security.context")->setToken($token); // now the user is logged in

        // now dispatch the login event
        $event = new InteractiveLoginEvent($this->getRequest(), $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    }
}
