<?php

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;

class AdminControllerTest extends ControllerTestCase
{
    public function testIndex(): void
    {
        static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals(['status' => true]);
    }

    public function testGetAllAccount(): void
    {
        $this->createClientWithCredentials()->request('GET', '/admin/account');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            [
                'email' => AppFixtures::ACCOUNTS[0]['email'],
                'company' => AppFixtures::ACCOUNTS[0]['company'],
            ]
        ]);
    }

    public function testDeleteAccount(): void
    {
        $account = AppFixtures::ACCOUNTS[1];
        $this->createClientWithCredentials()->request('DELETE', '/admin/account/'.$this->getAccountIdByEmail($account['email']));

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'deleted' => true,
        ]);
    }
}
