<?php

namespace App\Tests\Functional;

class AccountControllerTest extends ControllerTestCase
{
    public function testIndex(): void
    {
        $response = $this->createClientWithCredentials()->request('GET', '/profile');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'email' => 'c_croizat@hetic.eu',
            'company' => 'Hetic',
//            'countries' => ['fr', 'en', 'es'],
//            'roles' => ['ROLE_USER', 'ROLE_ADMIN'],
        ]);
    }
}
