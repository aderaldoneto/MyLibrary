<?php

namespace App\Repository;

use App\Entity\Autor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Autor> */
class AutorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Autor::class);
    }

    /** @return list<Autor> */
    public function findAllAlphabetically(): array
    {
        return $this->createQueryBuilder('autor')
            ->orderBy('autor.nome', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /** @return list<Autor> */
    public function findPage(int $page, int $limit = 10): array
    {
        $page = max(1, $page);

        return $this->createQueryBuilder('autor')
            ->orderBy('autor.nome', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('autor')
            ->select('count(autor.codigo)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
