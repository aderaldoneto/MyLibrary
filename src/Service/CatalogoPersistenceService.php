<?php

namespace App\Service;

use App\Exception\CatalogoPersistenceException;
use App\Exception\RegistroDuplicadoException;
use App\Exception\RegistroEmUsoException;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;

final class CatalogoPersistenceService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function salvar(object $entidade): void
    {
        try {
            $this->entityManager->persist($entidade);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            throw new RegistroDuplicadoException('Já existe um registro com estes dados!', previous: $exception);
        } catch (ForeignKeyConstraintViolationException $exception) {
            throw new RegistroEmUsoException('Não foi possível salvar o registro por causa de um vínculo inválido!', previous: $exception);
        } catch (\Throwable $exception) {
            throw new CatalogoPersistenceException('Não foi possível salvar o registro!', previous: $exception);
        }
    }

    public function excluir(object $entidade): void
    {
        try {
            $this->entityManager->remove($entidade);
            $this->entityManager->flush();
        } catch (ForeignKeyConstraintViolationException $exception) {
            throw new RegistroEmUsoException('O registro não pode ser excluído porque possui vínculos!', previous: $exception);
        } catch (\Throwable $exception) {
            throw new CatalogoPersistenceException('Não foi possível excluir o registro!', previous: $exception);
        }
    }
}
