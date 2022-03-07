<?php

namespace App\Domain\Service;

use App\Entity\Translation;

class TranslationService
{
    public function updateTranslation(Translation $translation, string $value): Translation
    {
        return $translation->setValue($value);
    }
}