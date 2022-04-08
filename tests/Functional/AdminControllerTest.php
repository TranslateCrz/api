<?php

namespace App\Tests\Functional;

class AdminControllerTest extends ControllerTestCase
{
    public function testIndex(): void
    {
        $response = static::createClient()->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['status' => true]);
    }
}
