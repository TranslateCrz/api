<?php

namespace App\Application\Repository;

use App\Entity\Account;
use App\Entity\Aggregate;
use App\Entity\Translation;
use Doctrine\Persistence\ObjectRepository;

interface TranslationRepositoryInterface extends ObjectRepository
{
    public function save(Aggregate $aggregate): void;
    public function persist(Aggregate $aggregate): void;
    public function flush(): void;
    public function delete(Aggregate $aggregate): void;
    public function findByUuid(string $id): ?Translation;
    public function findByAccountAndCode(Account $account, string $code): ?Translation;
    /**
     * @return Translation[] Returns an array of Translation objects
     */
    public function findByAccount(Account $account);
}