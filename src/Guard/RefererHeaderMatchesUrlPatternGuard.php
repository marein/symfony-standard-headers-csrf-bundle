<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Marein\StandardHeadersCsrfBundle\UrlPattern\UrlPattern;
use Symfony\Component\HttpFoundation\Request;

final class RefererHeaderMatchesUrlPatternGuard implements Guard
{
    private UrlPattern $urlPattern;

    public function __construct(UrlPattern $urlPattern)
    {
        $this->urlPattern = $urlPattern;
    }

    public function isSafe(Request $request): bool
    {
        return $this->urlPattern->matches(
            $this->readRefererSchemeAndHttpHostFromRequest($request)
        );
    }

    private function readRefererSchemeAndHttpHostFromRequest(Request $request): string
    {
        $components = (array)parse_url(
            (string)$request->headers->get('referer', '')
        );

        $referer = ($components['scheme'] ?? '') . '://' . ($components['host'] ?? '');

        if (array_key_exists('port', $components)) {
            $referer .= ':' . $components['port'];
        }

        return $referer;
    }
}
