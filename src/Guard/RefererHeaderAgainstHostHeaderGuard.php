<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Guard;

use Symfony\Component\HttpFoundation\Request;

final class RefererHeaderAgainstHostHeaderGuard implements Guard
{
    /**
     * @inheritdoc
     */
    public function isSafe(Request $request): bool
    {
        $referer = $request->headers->get('referer', '');

        // Append a slash to ensure that the domain part is set.
        return strpos(
            $referer . '/',
            $request->getSchemeAndHttpHost() . '/'
        ) === 0;
    }
}
