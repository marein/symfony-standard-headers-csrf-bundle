<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Tests\Integration;

use Marein\StandardHeadersCsrfBundle\MareinStandardHeadersCsrfBundle;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private string $uniqueId;

    private array $bundleConfiguration;

    public function __construct(array $bundleConfiguration)
    {
        parent::__construct('prod', false);

        $this->uniqueId = uniqid();
        $this->bundleConfiguration = $bundleConfiguration;
    }

    public function getCacheDir(): string
    {
        return '/tmp/' . $this->uniqueId . '/cache';
    }

    public function getLogDir(): string
    {
        return '/tmp/' . $this->uniqueId . '/log';
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new MareinStandardHeadersCsrfBundle()
        ];
    }

    protected function configureRoutes(RoutingConfigurator $routingConfigurator)
    {
        $routingConfigurator
            ->add('index', '/')
            ->controller('kernel::defaultAction')
            ->add('api_users', '/api/users')
            ->controller('kernel::defaultAction')
            ->add('user_logout', '/user/logout')
            ->controller('kernel::defaultAction')
            ->add('user_login', '/user/profile')
            ->controller('kernel::defaultAction');
    }

    protected function configureContainer(ContainerBuilder $containerBuilder, LoaderInterface $loader)
    {
        $containerBuilder->loadFromExtension(
            'marein_standard_headers_csrf',
            $this->bundleConfiguration
        );

        $containerBuilder->register('logger', NullLogger::class);
    }

    public function defaultAction(Request $r): Response
    {
        return new Response('Hello World');
    }
}
