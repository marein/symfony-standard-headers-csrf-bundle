<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Marein\StandardHeadersCsrfBundle\UrlPattern\UrlPattern;
use Symfony\Component\HttpFoundation\Request;

final class OriginHeaderMatchesUrlPatternGuard implements Guard
{
    /**
     * @var UrlPattern
     */
    private UrlPattern $urlPattern;

    /**
     * OriginHeaderMatchesUrlPatternGuard constructor.
     *
     * @param UrlPattern $urlPattern
     */
    public function __construct(UrlPattern $urlPattern)
    {
        $this->urlPattern = $urlPattern;
    }

    /**
     * @inheritdoc
     */
    public function isSafe(Request $request): bool
    {
        return $this->urlPattern->matches(
            (string)$request->headers->get('origin', '')
        );
    }
}
