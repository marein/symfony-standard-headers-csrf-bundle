<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class FeatureToggleGuard implements Guard
{
    private bool $isEnabled;

    private Guard $guard;

    public function __construct(bool $isEnabled, Guard $guard)
    {
        $this->isEnabled = $isEnabled;
        $this->guard = $guard;
    }

    public function isSafe(Request $request): bool
    {
        return $this->isEnabled && $this->guard->isSafe($request);
    }
}
