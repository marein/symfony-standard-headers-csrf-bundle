<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class OriginHeaderEqualsNullGuard implements Guard
{
    /**
     * @inheritdoc
     */
    public function isSafe(Request $request): bool
    {
        return $request->headers->get('origin', '') === 'null';
    }
}
