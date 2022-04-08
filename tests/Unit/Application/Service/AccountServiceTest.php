<?php

namespace App\Tests\Unit\Application\Service;

use App\Application\Dto\RegisterDto;
use App\Application\Repository\AccountRepositoryInterface;
use App\Application\Service\AccountService;
use App\Application\Validator\Validator;
use App\Domain\Factory\AccountFactory;
use App\Domain\Service\AccountService as AccountDomainService;
use App\Entity\Account;
use App\Tests\Unit\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountServiceTest extends UnitTestCase
{
    protected AccountService $accountService;
    protected MockObject $accountFactory;
    protected MockObject $accountDomainService;
    protected MockObject $accountRepositoryInterface;
    protected MockObject $validator;
    protected MockObject $security;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountFactory = $this->createMock(AccountFactory::class);
        $this->accountDomainService = $this->createMock(AccountDomainService::class);
        $this->accountRepositoryInterface = $this->createMock(AccountRepositoryInterface::class);
        $this->validator = $this->createMock(Validator::class);
        $this->security = $this->createMock(Security::class);
        $this->accountService = new AccountService(
            $this->accountFactory,
            $this->accountDomainService,
            $this->accountRepositoryInterface,
            $this->validator,
            $this->security,
        );
    }

    public function testCreate(): void
    {
        // given
        $dto = $this->getRegisterDto();

        // expect
        $this->expectValidatorToValidate();
        $this->expectFactoryToCreateAccount();
        $this->expectRepositoryToSave();

        // when
        $account = $this->whenAccountIsCreated($dto);

        // expect
        $this->expectAccount($account);
    }

    public function testGetNull(): void
    {
        // given
        $id = 'id';

        // expect
        $this->expectRepositoryToGet();

        // when
        $account = $this->whenAccountIsGet($id);

        // expect
        $this->assertNull($account);
    }

    public function testGet(): void
    {
        // given
        $id = 'id';

        // expect
        $this->expectRepositoryToGet($this->getAccount());

        // when
        $account = $this->whenAccountIsGet($id);

        // expect
        $this->expectAccount($account);
    }

    public function testGetNullBySecurity(): void
    {
        // given
        $id = null;

        // expect
        $this->expectSecurityToGetUser();

        // when
        $account = $this->whenAccountIsGet($id);

        // expect
        $this->assertNull($account);
    }

    public function testGetByEmail(): void
    {
        // given
        $email = 'email';

        // expect
        $this->expectRepositoryToGetByEmail();

        // when
        $account = $this->whenAccountIsGetByEmail($email);

        // expect
        $this->expectAccount($account);
    }

    public function testGetAll(): void
    {
        // expect
        $this->expectRepositoryToGetAll();

        // when
        $accounts = $this->whenAccountIsGetAll();

        // expect
        foreach ($accounts as $account) {
            $this->expectAccount($account);
        }
    }

    public function testUpdate(): void
    {
        // given
        $id = 'id';
        $dto = $this->getRegisterDto();

        // expect
        $this->expectRepositoryToGet($this->getAccount());
        $this->expectServiceToUpdate();
        $this->expectRepositoryToSave();

        // when
        $account = $this->whenAccountIsUpdated($id, $dto);

        // expect
        $this->expectAccount($account);
    }

    public function testDelete(): void
    {
        // given
        $id = 'id';

        // expect
        $this->expectRepositoryToGet($this->getAccount());
        $this->expectRepositoryToDelete();

        // when
        $account = $this->whenAccountIsDeleted($id);

        // expect
        $this->assertTrue($account);
    }

    public function getRegisterDto(): RegisterDto
    {
        $dto = new RegisterDto();
        $dto->email = 'email';
        $dto->countries = ['fr'];

        return $dto;
    }

    public function whenAccountIsCreated(RegisterDto $dto): Account
    {
        return $this->accountService->create($dto);
    }

    public function expectAccount(Account $account): void
    {
        $this->assertInstanceOf(Account::class, $account);
    }

    public function expectValidatorToValidate(): void
    {
        $this->validator->expects($this->once())
            ->method('validate')
        ;
    }

    public function expectFactoryToCreateAccount(): void
    {
        $this->accountFactory->expects($this->once())
            ->method('createAccount')
            ->willReturn($this->getAccount())
        ;
    }

    public function expectServiceToUpdate(): void
    {
        $this->accountDomainService->expects($this->once())
            ->method('updateTranslation')
            ->willReturn($this->getAccount())
        ;
    }

    public function expectRepositoryToDelete(): void
    {
        $this->accountRepositoryInterface->expects($this->once())
            ->method('delete')
        ;
    }

    public function expectRepositoryToSave(): void
    {
        $this->accountRepositoryInterface->expects($this->once())
            ->method('save')
        ;
    }

    public function whenAccountIsGet(?string $id = null): null|Account|UserInterface
    {
        return $this->accountService->get($id);
    }

    public function whenAccountIsGetByEmail(?string $id = null): ?Account
    {
        return $this->accountService->getByEmail($id);
    }

    public function whenAccountIsGetAll(): iterable
    {
        return $this->accountService->getAll();
    }

    public function whenAccountIsUpdated(?string $id, RegisterDto $dto): ?Account
    {
        return $this->accountService->update($id, $dto);
    }

    public function whenAccountIsDeleted(string $id): bool
    {
        return $this->accountService->delete($id);
    }

    public function expectRepositoryToGet(Account $account = null): void
    {
        $this->accountRepositoryInterface->expects($this->once())
            ->method('findByUuid')
            ->willReturn($account)
        ;
    }

    public function expectRepositoryToGetByEmail(): void
    {
        $this->accountRepositoryInterface->expects($this->once())
            ->method('findByEmail')
            ->willReturn($this->getAccount())
        ;
    }

    public function expectRepositoryToGetAll(): void
    {
        $this->accountRepositoryInterface->expects($this->once())
            ->method('findAll')
            ->willReturn([$this->getAccount()])
        ;
    }

    public function expectSecurityToGetUser(): void
    {
        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn(null)
        ;
    }
}
