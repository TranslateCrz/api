<?php

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;

class AccountControllerTest extends ControllerTestCase
{
    public function testIndex(): void
    {
        $this->createClientWithCredentials()->request('GET', '/profile');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'email' => AppFixtures::ACCOUNTS[0]['email'],
            'company' => AppFixtures::ACCOUNTS[0]['company'],
        ]);
    }
}
