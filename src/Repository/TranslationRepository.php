<?php

namespace App\Repository;

use App\Application\Repository\TranslationRepositoryInterface;
use App\Entity\Account;
use App\Entity\Aggregate;
use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[]    findAll()
 * @method Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends ServiceEntityRepository implements TranslationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

    /**
     * @return Translation[] Returns an array of Translation objects
     */
    public function findByAccount(Account $account)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.account = :val')
            ->setParameter('val', $account)
            ->getQuery()
            ->getResult()
        ;
    }

    public function save(Aggregate $aggregate): void
    {
        $this->_em->persist($aggregate);
        $this->_em->flush();
    }

    public function persist(Aggregate $aggregate): void
    {
        $this->_em->persist($aggregate);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function delete(Aggregate $aggregate): void
    {
        $this->_em->remove($aggregate);
        $this->_em->flush();
    }

    public function findByUuid(string $id): ?Translation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.uuid = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findByAccountAndCode(Account $account, string $code): ?Translation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.account = :val')
            ->setParameter('val', $account)
            ->andWhere('a.code = :code')
            ->setParameter('code', $code)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
