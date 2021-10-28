<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class KernelTestCase extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function itShouldWorkAsConfigured(
        string $method,
        string $path,
        string $origin,
        string $referer,
        int $expectedStatusCode
    ): void {
        static $kernel;
        $kernel ??= $this->createKernel();

        $serverParameters = [];

        $serverParameters['HTTP_ORIGIN'] = $origin;
        $serverParameters['HTTP_REFERER'] = $referer;

        $response = $kernel->handle(
            Request::create($path, $method, [], [], [], $serverParameters)
        );

        $this->assertEquals($expectedStatusCode, $response->getStatusCode());
    }

    public function createRequest(
        string $method,
        string $path,
        string $origin,
        string $referer,
        int $expectedStatusCode
    ): array {
        return func_get_args();
    }

    abstract protected function createKernel(): Kernel;

    abstract public function dataProvider(): array;
}
