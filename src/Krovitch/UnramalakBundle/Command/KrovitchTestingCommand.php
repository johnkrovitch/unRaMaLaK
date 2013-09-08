<?php

namespace Krovitch\UnramalakBundle\Command;
use GeorgetteParty\BaseBundle\Command\BaseCommandLine;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KrovitchTestingCommand extends BaseCommandLine
{
    public function configure()
    {
        $this->setName('krovitch:testing');
    }

    // TODO make it works for travis (return phpunit values)
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Testing Krovitch Bundle !');
        $this->executeCommand('phpunit', array('-c' => 'app/phpunit.xml'), $output);
        $this->executeCommand('bin/behat', array('' => '@UnramalakBundle'), $output);
    }
}