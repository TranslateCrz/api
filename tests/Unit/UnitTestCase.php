<?php

namespace App\Tests\Unit;

use App\Entity\Account;
use App\Entity\Translation;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    public function getAccount(string $email = 'email'): Account
    {
        return new Account($email);
    }

    public function getTranslation(Account $account = null, string $code = 'home.title'): Translation
    {
        return new Translation($account ?? $this->getAccount(), $code);
    }
}
