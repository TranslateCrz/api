<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Application\Repository\AccountRepositoryInterface;
use App\DataFixtures\AppFixtures;

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

    protected function getAccountIdByEmail(string $email = AppFixtures::ACCOUNTS[0]['email']): string
    {
        $repository = static::getContainer()->get(AccountRepositoryInterface::class);
        $account = $repository->findByEmail($email);

        return $account?->getUuid();
    }
}
