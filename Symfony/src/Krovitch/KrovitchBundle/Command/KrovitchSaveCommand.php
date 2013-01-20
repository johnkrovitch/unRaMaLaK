<?php

namespace Krovitch\KrovitchBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Exception\ParseException;

class KrovitchSaveCommand extends BaseCommandLine
{
    public function configure()
    {
        $this->setName('krovitch:save');
        $this->addOption('path', null, InputOption::VALUE_NONE, 'Path to dump file');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getOption('path');

        if (!$path) {
            $path = $this->getRelativeRootDir() . 'init/sql/unramalak.sql';
        }
        // get parameters from parameters.yml file
        $parameters = $this->getApplicationParameters();
        $command = $this->getMysqlDumpCommand($parameters, $path);
        // execute cmd command
        $output->writeln('Start dump database...');
        $this->executeCommand($command, array(), $output);
        $output->writeln('Database dumped successfully !');
    }

    protected function getMysqlDumpCommand($parameters, $path)
    {
        if (!array_key_exists('parameters', $parameters) || !count($parameters)) {
            throw new ParseException('Missing or empty key "parameters:" in parameters.yml');
        }
        $ymlParameters = $parameters['parameters'];
        $defaultsParameters = array('database_host' => '127.0.0.1', 'database_driver' => 'pdo_mysql');
        $requiredParameters = array('database_name', 'database_user', 'database_password');
        // checking pdo driver
        if (array_key_exists('database_driver', $ymlParameters) && $ymlParameters['database_driver'] != 'pdo_mysql') {
            throw new ParseException('PDO driver not supported ! Only pdo_mysql is supported yet.');
        }
        // checking required mysql options
        foreach ($requiredParameters as $parameter) {
            if (!array_key_exists($parameter, $ymlParameters)) {
                throw new ParseException('Missing required parameters in parameters.yml file: ' . $parameter);
            }
        }
        // checking optional mysql port
        $port = (array_key_exists('database_port', $ymlParameters) && $ymlParameters['database_port']) ? ' -P ' . $ymlParameters['database_port'] : '';
        // merging default parameters
        $ymlParameters = array_merge($defaultsParameters, $ymlParameters);
        // generating command
        $commandLine = 'mysqldump -h %s' . $port . ' -u %s -p%s %s > %s';
        $commandLine = sprintf(
            $commandLine,
            $ymlParameters['database_host'],
            $ymlParameters['database_user'],
            $ymlParameters['database_password'],
            $ymlParameters['database_name'],
            $path
        );
        return $commandLine;
    }
}