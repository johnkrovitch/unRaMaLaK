<?php

namespace Krovitch\KrovitchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\Yaml\Parser;

class BaseCommandLine extends ContainerAwareCommand
{
    public function executeCommand($command, $arguments = array(), OutputInterface $printOutput = null)
    {
        $argumentsCommand = ' ';
        $output = array();
        $this->cleanCommand($command);
        // writing arguments for command
        foreach ($arguments as $name => $value) {
            $argumentsCommand .= $name . ' ' . $value;
        }
        $commandLine = $command . $argumentsCommand;
        // execute command
        exec($commandLine, $output);

        if ($printOutput) {
            foreach ($output as $line) {
                $printOutput->writeln($line);
            }
        }
        return $output;
    }

    public function cleanCommand($command)
    {
        if (!$command) {
            throw new InvalidArgumentException('Trying to execute an empty command');
        }
        if (strpos($command, 'rm -rf /') > -1) {
            throw new InvalidArgumentException('Trying to remove EVERYTHING !!!');
        }
    }

    public function getRelativeRootDir()
    {
        return __DIR__ . '/../../../../';
    }

    /**
     * Return parameters from parameters.yml
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @throws \Symfony\Component\Yaml\Exception\ParseException;
     */
    public function getApplicationParameters()
    {
        $parser = new Parser();
        $parametersFilePath = $this->getRelativeRootDir() . 'app/config/parameters.yml';

        return $parser->parse(file_get_contents($parametersFilePath));
    }
}