<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('marein_standard_headers_csrf');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('allowed_paths')
                    ->scalarPrototype()->end()
                ->end()
                ->arrayNode('allowed_origins')
                    ->scalarPrototype()->end()
                ->end()
                ->booleanNode('fallback_to_referer')->defaultTrue()->end()
                ->booleanNode('allow_null_origin')->defaultFalse()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
