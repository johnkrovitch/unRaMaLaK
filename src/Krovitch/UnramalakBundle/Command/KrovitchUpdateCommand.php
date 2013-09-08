<?php

namespace Krovitch\UnramalakBundle\Command;
use GeorgetteParty\BaseBundle\Command\BaseCommandLine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KrovitchUpdateCommand extends BaseCommandLine
{
    public function configure()
    {
        $this->setName('krovitch:up');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO refactor this part, to make it more generic
        // git pull
        $gitPull = 'git pull';
        // update i18n files
        $translationUpdateFr = 'app/console translation:update fr UnramalakBundle --force';
        $translationUpdateEn = 'app/console translation:update en UnramalakBundle --force';
        // bower update
        $bower = 'bower install paper qunit jquery jquery.ui';
        $composer = 'php composer.phar update';
        // clear cache
        $cc = 'app/console cache:clear';

        $output->writeln('Updating Krovitch Bundle !');
        $this->executeCommands(array($gitPull, $translationUpdateFr, $translationUpdateEn, $bower, $composer, $cc), $output);
    }
}