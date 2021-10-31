<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

interface Guard
{
    public function isSafe(Request $request): bool;
}
