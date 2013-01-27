<?php

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as BaseScriptHandler;
use Composer\Script\Event;

// NOT WORKING YET
class ScriptHandler extends BaseScriptHandler
{
    public static function updateTranslations(Event $event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];
        // commands to execute and parameters
        $command = 'translation:update %s %s --force';
        $commands = array();
        $locales = array('en', 'fr');
        $bundles = array('KrovitchBundle', 'KrovitchUserBundle');

        foreach ($locales as $locale) {
            foreach ($bundles as $bundle) {
                $commands[] = sprintf($command, $locale, $bundle);
            }
        }
        static::executeCommands($event, $appDir, $commands);
    }

    public function executeCommands(Event $event, $appDir, array $commands)
    {
        foreach ($commands as $command) {
            static::executeCommand($event, $appDir, $command);
        }
    }
}