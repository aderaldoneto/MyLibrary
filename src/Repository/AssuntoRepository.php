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
}
