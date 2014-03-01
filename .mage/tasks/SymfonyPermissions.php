<?php

namespace Task;

use Mage\Task\AbstractTask;

class SymfonyPermissions extends AbstractTask
{
    /**
     * Returns the Title of the Task
     *
     * @return string
     */
    public function getName()
    {
        return 'Fix symfony2 permissions';
    }

    /**
     * Runs the task
     *
     * @return boolean
     * @throws \Exception
     * @throws \Mage\Task\ErrorWithMessageException
     * @throws \Mage\Task\SkipException
     */
    public function run()
    {
        // TODO handle other permissions types
        $command = 'sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs';
        $this->runCommandRemote($command);
        $command2 = '$ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs';
        $this->runCommandRemote($command2);
    }
}