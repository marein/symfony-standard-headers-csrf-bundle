<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Tests\Integration;

final class DisabledRefererFallbackBundleTest extends KernelTestCase
{
    /**
     * @inheritdoc
     */
    protected function createKernel(): Kernel
    {
        return new Kernel(
            [
                'fallback_to_referer' => false
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function dataProvider(): array
    {
        return [
            $this->createRequest(
                'POST',
                '/api/users',
                'http://localhost',
                '',
                200
            ),
            $this->createRequest(
                'GET',
                '/api/users',
                '',
                'http://localhost',
                200
            ),
            $this->createRequest(
                'POST',
                '/api/users',
                '',
                'http://localhost',
                403
            )
        ];
    }
}
