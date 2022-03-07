<?php

namespace App\Application\Service;

use App\Application\Repository\TranslationRepositoryInterface;
use App\Domain\Factory\TranslationFactory;
use App\Domain\Service\TranslationService as TranslationDomainService;
use App\Entity\Translation;

class TranslationService
{
    protected TranslationFactory $factory;
    protected TranslationDomainService $service;
    protected TranslationRepositoryInterface $repository;

    public function __construct(
        TranslationFactory $factory,
        TranslationDomainService $service,
        TranslationRepositoryInterface $repository
    ) {
        $this->factory = $factory;
        $this->service = $service;
        $this->repository = $repository;
    }

    public function create(string $code, string $country = 'FRA', ?string $value = null): Translation
    {
        $translation = $this->factory->createTranslation($code, $country, $value);
        $this->repository->save($translation);

        return $translation;
    }

    public function get(string $id): ?Translation
    {
        return $this->repository->findByUuid($id);
    }

    /**
     * @return Translation[]
     */
    public function getAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function update(string $id, string $value): ?Translation
    {
        if ($translation = $this->get($id)) {
            $translation = $this->service->updateTranslation($translation, $value);
            $this->repository->save($translation);
        }

        return $translation;
    }

    public function delete(string $id): bool
    {
        if ($translation = $this->get($id)) {
            $this->repository->delete($translation);
        }

        return (bool)$translation;
    }
}