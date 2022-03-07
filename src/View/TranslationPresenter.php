<?php

namespace App\View;

use App\Entity\Translation;

class TranslationPresenter
{
    public function presentTranslation(Translation $translation): TranslationView
    {
        $view = new TranslationView();
        $view->id = $translation->getUuid();
        $view->code = $translation->getCode();
        $view->value = $translation->getValue();
        $view->country = $translation->getCountry();
        $view->createdAt = $translation->getCreatedAt()->format('c');

        return $view;
    }

    /**
     * @param iterable|Translation[] $translations
     * @return array|TranslationView[]
     */
    public function presentTranslations(iterable $translations): array
    {
        $view = [];
        foreach ($translations as $translation) {
            $view[] = $this->presentTranslation($translation);
        }

        return $view;
    }
}