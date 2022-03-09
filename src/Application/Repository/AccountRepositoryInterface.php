<?php

namespace App\Application\Repository;

use App\Entity\Account;
use App\Entity\Aggregate;
use Doctrine\Persistence\ObjectRepository;

interface AccountRepositoryInterface extends ObjectRepository
{
    public function save(Aggregate $aggregate): void;
    public function delete(Aggregate $aggregate): void;
    public function findByUuid(string $id): ?Account;
    public function findByEmail(string $email): ?Account;
}