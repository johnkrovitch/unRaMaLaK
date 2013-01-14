<?php

namespace Krovitch\KrovitchBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Krovitch\KrovitchBundle\DependencyInjection\Configuration;

class KrovitchExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // services
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
        // configuration
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter('krovitch.unit.upload_dir', $config['unit']['upload_dir']);
    }

    public function getAlias()
    {
        return 'krovitch';
    }
}