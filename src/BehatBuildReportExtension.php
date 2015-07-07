<?php

namespace Softbox\BehatBuildReport;

use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class BehatBuildReportExtension
 * @package Features\Formatter
 */
class BehatBuildReportExtension implements ExtensionInterface {
    /**
    * You can modify the container here before it is dumped to PHP code.
    *
    * @param ContainerBuilder $container
    *
    * @api
    */
    public function process(ContainerBuilder $container) {
    }

    /**
    * Returns the extension config key.
    *
    * @return string
    */
    public function getConfigKey() {
        return "behatbuildreport";
    }

    /**
    * Initializes other extensions.
    *
    * This method is called immediately after all extensions are activated but
    * before any extension `configure()` method is called. This allows extensions
    * to hook into the configuration of other extensions providing such an
    * extension point.
    *
    * @param ExtensionManager $extensionManager
    */
    public function initialize(ExtensionManager $extensionManager) {
    }

    /**
    * Setups configuration for the extension.
    *
    * @param ArrayNodeDefinition $builder
    */
    public function configure(ArrayNodeDefinition $builder) {
        $builder
            ->children()
                ->scalarNode('name')->defaultValue('html')->end()
                ->scalarNode('build_nro')->defaultValue('generated')->end()
                ->scalarNode('matrix_name')->defaultValue('default')->end()
                ->scalarNode('file_name')->defaultValue('generated')->end()
            ->end();
    }

    /**
    * Loads extension services into temporary container.
    *
    * @param ContainerBuilder $container
    * @param array $config
    */
    public function load(ContainerBuilder $container, array $config) {
//        dump($config, $container->get('suite.registry'));exit;
        $definition = new Definition("Softbox\\BehatBuildReport\\Formatter\\BehatReportFormatter");
        $definition->addArgument($config['name']);
        $definition->addArgument($config['build_nro']);
        $definition->addArgument($config['file_name']);
        $definition->addArgument($config['matrix_name']);

        $definition->addArgument('%paths.base%');

        $container->setDefinition("html.formatter", $definition)->addTag("output.formatter");
    }
}