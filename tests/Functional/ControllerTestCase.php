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

    protected function createClientWithCredentials(string $token = AppFixtures::ACCOUNTS[0]['email']): Client
    {
        return static::createClient([], ['headers' => ['authorization' => $token]]);
    }

    protected function createRequest(string $url = '/', string $method = 'GET', array $data = [], Client $client = null): void
    {
        if (!$client) {
            $client = $this->createClientWithCredentials();
        }
        $client->request($method, $url, ['body' => json_encode($data)]);
    }

    protected function getAccountIdByEmail(string $email = AppFixtures::ACCOUNTS[0]['email']): string
    {
        $repository = static::getContainer()->get(AccountRepositoryInterface::class);
        $account = $repository->findByEmail($email);

        return $account?->getUuid();
    }
}
