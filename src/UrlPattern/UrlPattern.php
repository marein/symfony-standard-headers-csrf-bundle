<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\UrlPattern;

interface UrlPattern
{
    public const DELIMITER = '#';

    /**
     * Uses # as the delimiter.
     */
    public function matches(string $url): bool;
}
