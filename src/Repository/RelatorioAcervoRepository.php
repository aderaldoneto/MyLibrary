<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

final class RelatorioAcervoRepository
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return list<array{autor_codigo: string, autor_nome: string, livro_codigo: string, titulo: string, editora: string, edicao: int, ano_publicacao: string, valor: int, assuntos: string}>
     */
    public function findAllGroupedByAuthor(): array
    {
        return $this->connection->fetchAllAssociative(<<<'SQL'
            SELECT
                autor_codigo,
                autor_nome,
                livro_codigo,
                titulo,
                editora,
                edicao,
                ano_publicacao,
                valor,
                assuntos
            FROM vw_relatorio_livros_por_autor
            ORDER BY autor_nome ASC, titulo ASC
            SQL);
    }
}
