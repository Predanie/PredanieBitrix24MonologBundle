<?php

namespace Predanie\Bitrix24Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PredanieBitrix24MonologExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
	    $configuration = new Configuration();
	    $config = $this->processConfiguration($configuration, $configs);

	    $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
	    $loader->load('services.yml');

        $container->setParameter('bitrix24.chat_id', $config['bitrix24_chat_id']);
        $container->setParameter('bitrix24.user_id', $config['bitrix24_user_id']);
        $container->setParameter('bitrix24.webhook', $config['bitrix24_webhook']);
    }
}
