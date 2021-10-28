<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class RequestMethodIsSafeGuard implements Guard
{
    public function isSafe(Request $request): bool
    {
        return $request->isMethodSafe();
    }
}
