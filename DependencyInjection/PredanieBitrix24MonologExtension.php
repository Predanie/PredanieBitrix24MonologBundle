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

        $container->setParameter('predanie_bitrix24_monolog.chat_id', $config['chat_id']);
        $container->setParameter('predanie_bitrix24_monolog.user_id', $config['user_id']);
        $container->setParameter('predanie_bitrix24_monolog.webhook', $config['webhook']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
