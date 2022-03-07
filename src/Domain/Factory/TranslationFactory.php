<?php

namespace App\Domain\Factory;

use App\Entity\Translation;

class TranslationFactory
{
    public function createTranslation(string $code, string $country = 'FRA', ?string $value = null): Translation
    {
        return (new Translation($code, $country))->setValue($value);
    }
}