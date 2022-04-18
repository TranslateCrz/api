<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Application\Repository\AccountRepositoryInterface;
use App\Application\Repository\TranslationRepositoryInterface;
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

    protected function getTranslationIdByCodeAndEmail(
        string $code = AppFixtures::ACCOUNTS[0]['translations'][0]['code'],
        string $email = AppFixtures::ACCOUNTS[0]['email'],
    ): string {
        $repository = static::getContainer()->get(TranslationRepositoryInterface::class);

        return $repository->createQueryBuilder('t')
            ->select('t.uuid')
            ->leftJoin('t.account', 'a')
            ->andWhere('a.email = :val')
            ->setParameter('val', $email)
            ->andWhere('t.code = :code')
            ->setParameter('code', $code)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }
}
