<?php

namespace ArsThanea\KunstmaanAlgoliaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KunstmaanAlgoliaExtension extends Extension
{

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configs = (new Processor())->processConfiguration(new Configuration(), $configs);


        if (false === isset($configs['client'])) {
            return ;
        }

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        foreach ($configs['client'] as $key => $value) {
            $container->setParameter('arsthanea_kunstmaan_algolia.' . $key, $value);
        }

        if ($configs['client']['public_key']) {
            $loader->load('twig_extensions.yml');
        }

    }

}
