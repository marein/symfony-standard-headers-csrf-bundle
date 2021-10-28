<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle;

use Marein\StandardHeadersCsrfBundle\EventListener\CsrfGuardListener;
use Marein\StandardHeadersCsrfBundle\Guard\FeatureToggleGuard;
use Marein\StandardHeadersCsrfBundle\Guard\LogicalOrGuard;
use Marein\StandardHeadersCsrfBundle\Guard\OriginHeaderEqualsHostHeaderGuard;
use Marein\StandardHeadersCsrfBundle\Guard\OriginHeaderEqualsNullGuard;
use Marein\StandardHeadersCsrfBundle\Guard\OriginHeaderMatchesUrlPatternGuard;
use Marein\StandardHeadersCsrfBundle\Guard\RefererHeaderEqualsHostHeaderGuard;
use Marein\StandardHeadersCsrfBundle\Guard\RefererHeaderMatchesUrlPatternGuard;
use Marein\StandardHeadersCsrfBundle\Guard\RequestMethodIsSafeGuard;
use Marein\StandardHeadersCsrfBundle\Guard\RequestPathMatchesUrlPatternGuard;
use Marein\StandardHeadersCsrfBundle\UrlPattern\MultipleUrlPattern;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\KernelEvents;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(
            'marein_standard_headers_csrf.event_listener.csrf_guard_listener',
            CsrfGuardListener::class
        )
        ->args(
            [
                service('marein_standard_headers_csrf.guard')
            ]
        )
        ->tag('kernel.event_listener', ['event' => KernelEvents::REQUEST]);

    $container->services()
        ->set(
            'marein_standard_headers_csrf.url_pattern.allowed_paths',
            MultipleUrlPattern::class
        )
        ->args(
            [
                null
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.url_pattern.allowed_origins',
            MultipleUrlPattern::class
        )
        ->args(
            [
                null
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard',
            LogicalOrGuard::class
        )
        ->args(
            [
                [
                    service('marein_standard_headers_csrf.guard.request_method_is_safe_guard'),
                    service('marein_standard_headers_csrf.guard.request_path_matches_allowed_paths_guard'),
                    service('marein_standard_headers_csrf.guard.origin_header_equals_host_header_guard'),
                    service('marein_standard_headers_csrf.guard.origin_header_matches_allowed_origins_guard'),
                    service('marein_standard_headers_csrf.guard.referer_header_guard'),
                    service('marein_standard_headers_csrf.guard.origin_header_equals_null_guard')
                ]
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.request_method_is_safe_guard',
            RequestMethodIsSafeGuard::class
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.request_path_matches_allowed_paths_guard',
            RequestPathMatchesUrlPatternGuard::class
        )
        ->args(
            [
                service('marein_standard_headers_csrf.url_pattern.allowed_paths')
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.origin_header_equals_host_header_guard',
            OriginHeaderEqualsHostHeaderGuard::class
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.origin_header_matches_allowed_origins_guard',
            OriginHeaderMatchesUrlPatternGuard::class
        )
        ->args(
            [
                service('marein_standard_headers_csrf.url_pattern.allowed_origins')
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.referer_header_guard',
            LogicalOrGuard::class
        )
        ->args(
            [
                [
                    service('marein_standard_headers_csrf.guard.referer_header_equals_host_header_guard'),
                    service('marein_standard_headers_csrf.guard.referer_header_matches_allowed_origins_guard')
                ]
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.referer_header_guard.feature_toggle',
            FeatureToggleGuard::class
        )
        ->decorate('marein_standard_headers_csrf.guard.referer_header_guard')
        ->args(
            [
                null,
                service('.inner')
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.referer_header_equals_host_header_guard',
            RefererHeaderEqualsHostHeaderGuard::class
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.referer_header_matches_allowed_origins_guard',
            RefererHeaderMatchesUrlPatternGuard::class
        )
        ->args(
            [
                service('marein_standard_headers_csrf.url_pattern.allowed_origins')
            ]
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.origin_header_equals_null_guard',
            OriginHeaderEqualsNullGuard::class
        );

    $container->services()
        ->set(
            'marein_standard_headers_csrf.guard.origin_header_equals_null_guard.feature_toggle',
            FeatureToggleGuard::class
        )
        ->decorate('marein_standard_headers_csrf.guard.origin_header_equals_null_guard')
        ->args(
            [
                null,
                service('.inner')
            ]
        );
};
