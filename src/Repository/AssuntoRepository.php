<?php

namespace App\Repository;

use App\Entity\Assunto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Assunto> */
class AssuntoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assunto::class);
    }

    /** @return list<Assunto> */
    public function findAllAlphabetically(): array
    {
        return $this->createQueryBuilder('assunto')
            ->orderBy('assunto.descricao', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** @return list<Assunto> */
    public function findPage(int $page, int $limit = 10): array
    {
        $page = max(1, $page);

        return $this->createQueryBuilder('assunto')
            ->orderBy('assunto.descricao', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('assunto')
            ->select('count(assunto.codigo)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
