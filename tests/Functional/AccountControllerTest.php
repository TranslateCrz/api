<?php

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;

class AccountControllerTest extends ControllerTestCase
{
    public function testRegister(): void
    {
        $account = [
            'email' => 'test@hetic.net',
            'company' => 'test',
        ];

        $this->createRequest('/register', 'POST', $account, static::createClient());

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($account);
    }

    public function testLogin(): void
    {
        $email = AppFixtures::ACCOUNTS[0]['email'];

        $this->createRequest('/login', 'POST', ['email' => $email], static::createClient());

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals(['token' => $email]);
    }

    public function testGetMe(): void
    {
        $this->createRequest('/profile');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'email' => AppFixtures::ACCOUNTS[0]['email'],
            'company' => AppFixtures::ACCOUNTS[0]['company'],
        ]);
    }

    public function testPutMe(): void
    {
        $this->createRequest('/profile', 'PUT', ['company' => 'company']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'email' => AppFixtures::ACCOUNTS[0]['email'],
            'company' => 'company',
        ]);
    }
}
