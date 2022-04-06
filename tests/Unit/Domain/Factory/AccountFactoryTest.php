<?php

namespace App\Tests\Unit\Domain\Factory;

use App\Domain\Factory\AccountFactory;
use App\Entity\Account;
use App\Tests\Unit\UnitTestCase;

class AccountFactoryTest extends UnitTestCase
{
    protected AccountFactory $accountFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->accountFactory = new AccountFactory();
    }

    public function testCreateAccount(): void
    {
        // given
        $email = 'email';
        $countries = ['country'];
        $company = '$company';

        // when
        $account = $this->whenAccountIsCreated($email, $countries, $company);

        // expect
        $this->expectAccount($account, $email, $countries, $company);
    }

    public function whenAccountIsCreated(string $email, array $countries, ?string $company = null): Account
    {
        return $this->accountFactory->createAccount($email, $countries, $company);
    }

    public function expectAccount(Account $account, string $email, array $countries, ?string $company = null): void
    {
        $this->assertInstanceOf(Account::class, $account);
        $this->assertSame($email, $account->getEmail());
        $this->assertSame($countries, $account->getCountries());
        $this->assertSame($company, $account->getCompany());
    }
}
