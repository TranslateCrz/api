<?php

namespace App\Application\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto
{
    #[Assert\Email]
    public string $email;

    #[Assert\All([
        new Assert\Country
    ])]
    public array $countries;

    public ?string $company;
}