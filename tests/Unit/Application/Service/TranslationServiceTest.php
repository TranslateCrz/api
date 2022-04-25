<?php

namespace App\Tests\Unit\Application\Service;

use App\Application\Dto\TranslationDto;
use App\Application\Repository\TranslationRepositoryInterface;
use App\Application\Service\TranslationService;
use App\Application\Validator\Validator;
use App\Domain\Factory\TranslationFactory;
use App\Domain\Service\MessageServiceInterface;
use App\Domain\Service\TranslationService as TranslationDomainService;
use App\Entity\Translation;
use App\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\Security;

class TranslationServiceTest extends UnitTestCase
{
    protected TranslationService $translationService;
    protected MockObject $translationFactory;
    protected MockObject $translationDomainService;
    protected MockObject $translationRepositoryInterface;
    protected MockObject $validator;
    protected MockObject $security;
    protected MockObject $messageServiceInterface;

    protected function setUp(): void
    {
        parent::setUp();
        $this->translationFactory = $this->createMock(TranslationFactory::class);
        $this->translationDomainService = $this->createMock(TranslationDomainService::class);
        $this->translationRepositoryInterface = $this->createMock(TranslationRepositoryInterface::class);
        $this->validator = $this->createMock(Validator::class);
        $this->security = $this->createMock(Security::class);
        $this->messageServiceInterface = $this->createMock(MessageServiceInterface::class);
        $this->translationService = new TranslationService(
            $this->translationFactory,
            $this->translationDomainService,
            $this->translationRepositoryInterface,
            $this->validator,
            $this->security,
            $this->messageServiceInterface,
        );
    }

    public function testCreate(): void
    {
        // given
        $dto = $this->getTranslationDto();

        // expect
        $this->expectRepositoryToFindNullByAccount();
        $this->expectValidatorToValidate();
        $this->expectFactoryToCreateTranslation();
        $this->expectRepositoryToSave();
        $this->expectTranslationToBePublish();

        // when
        $account = $this->whenTranslationIsCreated($dto);

        // expect
        $this->expectTranslation($account);
    }

    public function getTranslationDto(): TranslationDto
    {
        $dto = new TranslationDto();
        $dto->code = 'home.title';
        $dto->country = 'fr';
        $dto->value = 'Titre';

        return $dto;
    }

    public function whenTranslationIsCreated(TranslationDto $dto): Translation
    {
        return $this->translationService->create($dto);
    }

    public function expectTranslation(Translation $translation): void
    {
        $this->assertInstanceOf(Translation::class, $translation);
    }

    public function expectValidatorToValidate(): void
    {
        $this->validator->expects($this->once())
            ->method('validate')
        ;
    }

    public function expectFactoryToCreateTranslation(): void
    {
        $this->translationFactory->expects($this->once())
            ->method('createTranslation')
            ->willReturn($this->getTranslation())
        ;
    }

    public function expectRepositoryToSave(): void
    {
        $this->translationRepositoryInterface->expects($this->once())
            ->method('save')
        ;
    }

    public function expectRepositoryToFindNullByAccount(): void
    {
        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn($this->getAccount())
        ;
        $this->translationRepositoryInterface->expects($this->once())
            ->method('findByAccountAndCode')
            ->willReturn(null)
        ;
    }

    public function expectTranslationToBePublish(): void
    {
        $this->messageServiceInterface->expects($this->once())
            ->method('publish')
        ;
    }
}
