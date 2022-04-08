<?php

namespace App\Tests\Unit\Domain\Service;

use App\Domain\Service\AccountService;
use App\Entity\Account;
use App\Tests\Unit\UnitTestCase;

class AccountServiceTest extends UnitTestCase
{
    protected AccountService $accountService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountService = new AccountService();
    }

    public function testCreateAccount(): void
    {
        // given
        $account = $this->getAccount();
        $countries = ['country'];
        $company = '$company';

        // when
        $account = $this->whenAccountIsUpdated($account, $countries, $company);

        // expect
        $this->expectAccount($account, $countries, $company);
    }

    public function whenAccountIsUpdated(Account $account, array $countries, string $company): Account
    {
        return $this->accountService->updateTranslation($account, $countries, $company);
    }

    public function expectAccount(Account $account, array $countries, string $company): void
    {
        $this->assertInstanceOf(Account::class, $account);
        $this->assertSame($countries, $account->getCountries());
        $this->assertSame($company, $account->getCompany());
    }
}
