<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class RequestPathMatchesAllowedPathsGuard implements Guard
{
    /**
     * @var string[]
     */
    private array $patterns;

    /**
     * RequestPathMatchesAllowedPathsGuard constructor.
     *
     * @param string[] $patterns
     */
    public function __construct(array $patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * @inheritdoc
     */
    public function isSafe(Request $request): bool
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match('#' . $pattern . '#', $request->getPathInfo())) {
                return true;
            }
        }

        return false;
    }
}
