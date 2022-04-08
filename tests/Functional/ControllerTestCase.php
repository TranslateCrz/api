<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;

abstract class ControllerTestCase extends ApiTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    protected function createClientWithCredentials(string $token = 'c_croizat@hetic.eu'): Client
    {
        return static::createClient([], ['headers' => ['authorization' => $token]]);
    }
}
