<?php

namespace App\Tests\Unit\Domain\Service;

use App\Domain\Service\TranslationService;
use App\Entity\Translation;
use App\Tests\Unit\UnitTestCase;

class TranslationServiceTest extends UnitTestCase
{
    protected TranslationService $translationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->translationService = new TranslationService();
    }

    public function testCreateTranslation(): void
    {
        // given
        $translation = $this->getTranslation();
        $value = '$value';

        // when
        $translation = $this->whenTranslationIsUpdated($translation, $value);

        // expect
        $this->expectTranslation($translation, $value);
    }

    public function whenTranslationIsUpdated(Translation $translation, string $value): Translation
    {
        return $this->translationService->updateTranslation($translation, $value);
    }

    public function expectTranslation(Translation $translation, string $value): void
    {
        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertSame($value, $translation->getValue());
    }
}
