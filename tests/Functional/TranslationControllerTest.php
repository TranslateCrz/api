<?php

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;

class TranslationControllerTest extends ControllerTestCase
{
    public function testCreate(): void
    {
        $translation = [
            'code' => 'article.title',
            'country' => 'fr',
            'value' => 'Le titre de l\'article',
        ];

        $this->createRequest('/translations', 'POST', $translation);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains($translation);
    }

    public function testGet(): void
    {
        $translationId = $this->getTranslationIdByCodeAndEmail();

        $this->createRequest('/translations/'.$translationId);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(AppFixtures::ACCOUNTS[0]['translations'][0]);
    }

    public function testGetAll(): void
    {
        $this->createRequest('/translations');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(AppFixtures::ACCOUNTS[0]['translations']);
    }

    // todo refactor AddCodes method from controller
//    public function testAddCodes(): void
//    {
//    }

    public function testPut(): void
    {
        $translationId = $this->getTranslationIdByCodeAndEmail();
        $title = 'Le nouveau titre de la page d\'accueil';

        $this->createRequest('/translations/'.$translationId, 'PUT', ['value' => $title]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'code' => AppFixtures::ACCOUNTS[0]['translations'][0]['code'],
            'country' => AppFixtures::ACCOUNTS[0]['translations'][0]['country'],
            'value' => $title,
        ]);
    }

    public function testDelete(): void
    {
        $translationId = $this->getTranslationIdByCodeAndEmail();

        $this->createRequest('/translations/'.$translationId, 'DELETE');

        $this->assertResponseIsSuccessful();
        $this->assertJsonEquals([
            'deleted' => true,
        ]);
    }
}
