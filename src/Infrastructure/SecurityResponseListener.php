<?php

declare(strict_types=1);

namespace Vanmoof\Infrastructure;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * NOTE: this is a fix for Symfony framework in order to parse the DATABASE URL in doctrine bundle
 */
final class SecurityResponseListener
{
    public function onKernelResponse(ResponseEvent $event): void
    {
        $headers = $event->getResponse()->headers;

        $headers->set('Strict-Transport-Security', 'max-age=16070400');
        $headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0');
    }
}
