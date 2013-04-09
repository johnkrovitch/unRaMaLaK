<?php

namespace Krovitch\KrovitchBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KrovitchTestCommand extends BaseCommandLine
{
    public function configure()
    {
        $this->setName('krovitch:test');
    }

    // TODO make it works for travis (return phpunit values)
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $command = 'phpunit';
        $arguments = array('-c' => 'app/phpunit.xml');

        $output->writeln('Testing Krovitch Bundle !');
        $this->executeCommand($command, $arguments, $output);
    }
}