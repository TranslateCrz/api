<?php

namespace App\Tests\Unit\Domain\Factory;

use App\Domain\Factory\TranslationFactory;
use App\Entity\Account;
use App\Entity\Translation;
use App\Tests\Unit\UnitTestCase;

class TranslationFactoryTest extends UnitTestCase
{
    protected TranslationFactory $translationFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->translationFactory = new TranslationFactory();
    }

    public function testCreateTranslation(): void
    {
        // given
        $account = $this->getAccount();
        $code = 'home.title';

        // when
        $translation = $this->whenTranslationIsCreated($account, $code);

        // expect
        $this->expectTranslation($translation, $account, $code);
    }

    public function whenTranslationIsCreated(Account $account, string $code): Translation
    {
        return $this->translationFactory->createTranslation($account, $code);
    }

    public function expectTranslation(Translation $translation, Account $account, string $code): void
    {
        $this->assertInstanceOf(Translation::class, $translation);
        $this->assertSame($account, $translation->getAccount());
        $this->assertSame($code, $translation->getCode());
    }
}
