<?php

namespace Krovitch\UnramalakBundle\Features\Context;

use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    use KernelDictionary;

    /**
     * @Given /^there are users:$/
     */
    public function thereAreUsers(TableNode $table)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        if (!count($users)) {
            foreach ($table->getHash() as $hash) {
                $user = $userManager->findUserByEmail($hash['email']);

                if ($user) {
                    continue;
                }
                $user = $userManager->createUser();
                $user->setUsername($hash['username']);
                $user->setPlainPassword($hash['password']);
                $user->setEmail($hash['email']);
                $user->setEnabled(true);
                $userManager->updateUser($user);
            }
        }
    }
}