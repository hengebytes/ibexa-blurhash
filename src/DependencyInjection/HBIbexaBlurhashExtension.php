<?php

namespace HengeBytes\IbexaBlurhashBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

class HBIbexaBlurhashExtension extends Extension implements PrependExtensionInterface
{
    private const SCHEMA_DIR_PATH = '/vendor/hengebytes/ibexa-blurhash/config/graphql';

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $schemaDir = $container->getParameter('kernel.project_dir') . self::SCHEMA_DIR_PATH;

        $graphQLConfig = [
            'definitions' => [
                'mappings' => [
                    'types' => [
                        ['type' => 'yaml', 'dir' => $schemaDir],
                    ],
                ],
            ],
        ];
        $container->prependExtensionConfig('overblog_graphql', $graphQLConfig);
    }
}
