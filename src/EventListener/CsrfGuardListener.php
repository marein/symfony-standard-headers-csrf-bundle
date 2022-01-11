<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\EventListener;

use Marein\StandardHeadersCsrfBundle\Guard\Guard;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final class CsrfGuardListener
{
    private Guard $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @throws AccessDeniedHttpException When a CSRF attack is detected.
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if ($this->isMainRequest($event) && !$this->guard->isSafe($event->getRequest())) {
            throw new AccessDeniedHttpException('CSRF attack detected.');
        }
    }

    /**
     * Symfony has renamed "isMasterRequest" to "isMainRequest".
     * This method encapsulates the logic to support multiple versions.
     */
    private function isMainRequest(RequestEvent $event): bool
    {
        if (method_exists($event, 'isMasterRequest')) {
            return $event->isMasterRequest();
        }

        return $event->isMainRequest();
    }
}
