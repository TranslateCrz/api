<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class Translation extends Aggregate
{
    #[ORM\Column(type: 'string', length: 50)]
    private string $code;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value;

    #[ORM\Column(type: 'string', length: 3)]
    private string $country;

    public function __construct(string $code, string $country = 'FRA')
    {
        parent::__construct();
        $this->code = $code;
        $this->value = null;
        $this->country = $country;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
