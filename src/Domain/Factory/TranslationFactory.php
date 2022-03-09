<?php

namespace App\Domain\Factory;

use App\Entity\Account;
use App\Entity\Translation;

class TranslationFactory
{
    public function createTranslation(Account $account, string $code, string $country = 'FRA', ?string $value = null): Translation
    {
        return (new Translation($account, $code, $country))->setValue($value);
    }
}