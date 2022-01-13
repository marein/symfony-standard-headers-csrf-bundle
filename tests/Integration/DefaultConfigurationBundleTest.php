<?php

declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Tests\Integration;

final class DefaultConfigurationBundleTest extends KernelTestCase
{
    protected function createKernel(): Kernel
    {
        static $kernel;
        return $kernel ??= new Kernel([]);
    }

    public function dataProvider(): array
    {
        return [
            $this->createRequest(
                'GET',
                '/api/users',
                'null',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                'http://localhost',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/api/users',
                'http://localhost',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                '',
                'http://localhost',
                200
            ),
            $this->createRequest(
                'POST',
                'http://localhost/user/profile',
                '',
                'http://localhosttrytoappend/test',
                403
            ),
            $this->createRequest(
                'POST',
                'http://localhost:8080/user/profile',
                'http://localhost:8080',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                'http://localhost:8080/user/profile',
                '',
                'http://localhost:8080',
                200
            ),
            $this->createRequest(
                'POST',
                '/api/users',
                'null',
                '',
                403
            ),
            $this->createRequest(
                'POST',
                '/api/users',
                'http://not-allowed.origin',
                '',
                403
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                '',
                'http://not-allowed.origin',
                403
            )
        ];
    }
}
