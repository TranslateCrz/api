<?php

namespace App\Domain\Service;

use App\Entity\Account;

class AccountService
{
    public function updateTranslation(Account $translation, array $countries, string $company): Account
    {
        return $translation->setCountries($countries)->setCompany($company);
    }
}