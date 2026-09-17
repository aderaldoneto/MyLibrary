<?php

namespace App\Repository;

use App\Entity\Livro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @extends ServiceEntityRepository<Livro> */
class LivroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livro::class);
    }

    /** @return list<Livro> */
    public function findAllForListing(): array
    {
        return $this->createQueryBuilder('livro')
            ->leftJoin('livro.autores', 'autor')->addSelect('autor')
            ->leftJoin('livro.assuntos', 'assunto')->addSelect('assunto')
            ->orderBy('livro.titulo', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneForDetail(int $codigo): ?Livro
    {
        return $this->createQueryBuilder('livro')
            ->leftJoin('livro.autores', 'autor')->addSelect('autor')
            ->leftJoin('livro.assuntos', 'assunto')->addSelect('assunto')
            ->andWhere('livro.codigo = :codigo')
            ->setParameter('codigo', $codigo)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
