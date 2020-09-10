<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class OriginHeaderAgainstHostHeaderGuard implements Guard
{
    /**
     * @inheritdoc
     */
    public function isSafe(Request $request): bool
    {
        $origin = $request->headers->get('origin', '');

        return $origin === $request->getSchemeAndHttpHost();
    }
}
