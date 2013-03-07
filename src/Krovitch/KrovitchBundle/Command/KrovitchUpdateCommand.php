<?php

namespace Krovitch\KrovitchBundle\Command;

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
        $command = 'app/console translation:update fr KrovitchBundle --force';
        $command2 = 'app/console translation:update en KrovitchBundle --force';
        $command3 = 'app/console cache:clear';
        $arguments = array();

        $output->writeln('Updating Krovitch Bundle !');
        $this->executeCommand($command, $arguments, $output);
        $this->executeCommand($command2, $arguments, $output);
        $this->executeCommand($command3, $arguments, $output);
    }
}