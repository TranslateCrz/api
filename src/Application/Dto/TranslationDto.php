<?php

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class TranslationDto
{
    #[Assert\NotBlank]
    public string $code;

    #[Assert\Language]
    public string $country;

    public ?string $value;
}