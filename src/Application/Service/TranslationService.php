<?php

namespace App\Application\Service;

use App\Application\Dto\TranslationDto;
use App\Application\Repository\TranslationRepositoryInterface;
use App\Application\Validator\Validator;
use App\Domain\Factory\TranslationFactory;
use App\Domain\Service\TranslationService as TranslationDomainService;
use App\Entity\Account;
use App\Entity\Translation;
use Symfony\Component\Security\Core\Security;

class TranslationService
{
    protected TranslationFactory $factory;
    protected TranslationDomainService $service;
    protected TranslationRepositoryInterface $repository;
    protected Validator $validator;
    protected Security $security;

    public function __construct(
        TranslationFactory $factory,
        TranslationDomainService $service,
        TranslationRepositoryInterface $repository,
        Validator $validator,
        Security $security
    ) {
        $this->factory = $factory;
        $this->service = $service;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->security = $security;
    }

    public function create(TranslationDto $dto): Translation
    {
        /**
         * @var Account $account
         */
        $account = $this->security->getUser();
        if ($translation = $this->repository->findByAccountAndCode($account, $dto->code)) {
            return $translation;
        }

        $this->validator->validate($dto);
        foreach ($account->getCountries() as $country) {
            if ($country === $dto->country) {
                $t = $translation = $this->factory->createTranslation($account, $dto->code, $dto->country, $dto->value);
            } else {
                $t = $this->factory->createTranslation($account, $dto->code, $country);
            }
            $this->repository->save($t);
        }

        return $translation;
    }

    public function get(string $id): ?Translation
    {
        $translation = $this->repository->findByUuid($id);
        if ($translation && $translation->getAccount() === $this->security->getUser()) {
            return $translation;
        }

        return null;
    }

    /**
     * @return Translation[]
     */
    public function getAll(): iterable
    {
        return $this->repository->findByAccount($this->security->getUser());
    }

    public function update(string $id, TranslationDto $dto): ?Translation
    {
        if ($translation = $this->get($id)) {
            $translation = $this->service->updateTranslation($translation, $dto->value);
            $this->repository->save($translation);
        }
        // send message
//        {
//            "Src": "EN",
//          "Val": "Welcome to Hetic-localize",
//          "Key": "welcome.user"
//        }

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