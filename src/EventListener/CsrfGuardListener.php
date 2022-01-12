<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\EventListener;

use LogicException;
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
     * @throws LogicException When the request cannot be processed due to program errors.
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
     *
     * @throws LogicException When the type of request cannot be determined.
     */
    private function isMainRequest(RequestEvent $event): bool
    {
        if (method_exists($event, 'isMainRequest')) {
            return $event->isMainRequest();
        } elseif (method_exists($event, 'isMasterRequest')) {
            return $event->isMasterRequest();
        }

        throw new LogicException(
            'The request type of the kernel cannot be determined.'
        );
    }
}
