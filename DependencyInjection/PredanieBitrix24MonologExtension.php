<?php

namespace Predanie\Bitrix24Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PredanieBitrix24MonologExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
	    $configuration = new Configuration();
	    $config = $this->processConfiguration($configuration, $configs);

	    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
	    $loader->load('services.yml');

        $container->setParameter('bitrix24.chat_id', $config['chat_id']);
        $container->setParameter('bitrix24.user_id', $config['user_id']);
        $container->setParameter('bitrix24.webhook', $config['webhook']);
    }
}
