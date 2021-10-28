<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\UrlPattern;

final class MultipleUrlPattern implements UrlPattern
{
    /**
     * @var string[]
     */
    private array $urlPatterns;

    /**
     * @param string[] $urlPatterns
     */
    public function __construct(array $urlPatterns)
    {
        $this->urlPatterns = $urlPatterns;
    }

    public function matches(string $url): bool
    {
        foreach ($this->urlPatterns as $expression) {
            if (preg_match(UrlPattern::DELIMITER . $expression . UrlPattern::DELIMITER, $url)) {
                return true;
            }
        }

        return false;
    }
}
