<?php

namespace App\Domain\Service;

use App\Entity\Translation;

interface MessageServiceInterface
{
    public function publish(Translation $translation);
}