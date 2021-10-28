<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class MareinStandardHeadersCsrfExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new PhpFileLoader(
            $container,
            new FileLocator(dirname(__DIR__) . '/Resources/config')
        );
        $loader->load('services.php');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->getDefinition('marein_standard_headers_csrf.url_pattern.allowed_paths')
            ->replaceArgument(0, $config['allowed_paths']);

        $container->getDefinition('marein_standard_headers_csrf.url_pattern.allowed_origins')
            ->replaceArgument(0, $config['allowed_origins']);

        $container->getDefinition('marein_standard_headers_csrf.guard.referer_header_guard.feature_toggle')
            ->replaceArgument(0, $config['fallback_to_referer']);

        $container->getDefinition('marein_standard_headers_csrf.guard.origin_header_equals_null_guard.feature_toggle')
            ->replaceArgument(0, $config['allow_null_origin']);
    }
}
