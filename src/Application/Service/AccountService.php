<?php

namespace App\Application\Service;

use App\Application\Dto\RegisterDto;
use App\Application\Repository\AccountRepositoryInterface;
use App\Application\Validator\Validator;
use App\Domain\Factory\AccountFactory;
use App\Domain\Service\AccountService as AccountDomainService;
use App\Entity\Account;
use Symfony\Component\Security\Core\Security;

class AccountService
{
    protected AccountFactory $factory;
    protected AccountDomainService $service;
    protected AccountRepositoryInterface $repository;
    protected Validator $validator;
    protected Security $security;

    public function __construct(
        AccountFactory $factory,
        AccountDomainService $service,
        AccountRepositoryInterface $repository,
        Validator $validator,
        Security $security
    ) {
        $this->factory = $factory;
        $this->service = $service;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->security = $security;
    }

    public function create(RegisterDto $dto): Account
    {
        $this->validator->validate($dto);

        $account = $this->factory->createAccount($dto->email, $dto->countries, $dto->company);
        $this->repository->save($account);

        return $account;
    }

    public function get(?string $id = null): ?Account
    {
        if ($id) {
            return $this->repository->findByUuid($id);
        } else {
            return $this->security->getUser();
        }
    }

    public function getByEmail(string $email): ?Account
    {
        return $this->repository->findByEmail($email);
    }

    /**
     * @return Account[]
     */
    public function getAll(): iterable
    {
        return $this->repository->findAll();
    }

    public function update(?string $id, RegisterDto $dto): ?Account
    {
        if ($id) {
            $account = $this->get($id);
        } else {
            $account = $this->security->getUser();
        }

        if ($account) {
            $account = $this->service->updateTranslation($account, $dto->countries, $dto->company);
            $this->repository->save($account);
        }

        return $account;
    }

    public function delete(string $id): bool
    {
        if ($account = $this->get($id)) {
            $this->repository->delete($account);
        }

        return (bool)$account;
    }
}