<?php

namespace App\Domain\Factory;

use App\Entity\Account;

class AccountFactory
{
    public function createAccount(string $email, array $countries, ?string $company = null): Account
    {
        return (new Account($email))->setCountries($countries)->setCompany($company);
    }
}