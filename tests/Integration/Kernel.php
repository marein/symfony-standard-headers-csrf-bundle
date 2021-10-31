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
use Symfony\Component\Routing\RouteCollectionBuilder;

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

    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new MareinStandardHeadersCsrfBundle()
        ];
    }

    protected function configureRoutes(RouteCollectionBuilder $routeCollectionBuilder)
    {
        $routeCollectionBuilder->add('/', 'kernel::defaultAction', 'index');
        $routeCollectionBuilder->add('/api/users', 'kernel::defaultAction', 'api_users');
        $routeCollectionBuilder->add('/user/logout', 'kernel::defaultAction', 'user_logout');
        $routeCollectionBuilder->add('/user/profile', 'kernel::defaultAction', 'user_login');
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
