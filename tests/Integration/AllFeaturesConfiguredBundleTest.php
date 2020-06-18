<?php
declare(strict_types=1);

namespace Marein\StandardHeadersCsrfBundle\Tests\Integration;

final class AllFeaturesConfiguredBundleTest extends KernelTestCase
{
    /**
     * @inheritdoc
     */
    protected function createKernel(): Kernel
    {
        return new Kernel(
            [
                'protected_paths'     => ['^(?!/api)'],
                'allowed_origins'     => ['http://allowed.origin'],
                'fallback_to_referer' => true,
                'allow_null_origin'   => true
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
                'GET',
                '/user/logout',
                'http://not-allowed.origin',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/api/users',
                'http://not-allowed.origin',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                'null',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                'http://allowed.origin',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/profile',
                '',
                'http://allowed.origin',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/logout',
                'http://localhost',
                '',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/logout',
                '',
                'http://localhost',
                200
            ),
            $this->createRequest(
                'POST',
                '/user/logout',
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
            )
        ];
    }
}
