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
    public function findAllGroupedByAuthor(?string $autor = null, ?string $editora = null, ?string $ano = null): array
    {
        $sql = <<<'SQL'
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
            WHERE 1 = 1
        SQL;

        $params = [];

        if ($autor !== null && trim($autor) !== '') {
            $sql .= ' AND LOWER(autor_nome) LIKE LOWER(:autor)';
            $params['autor'] = '%' . trim($autor) . '%';
        }

        if ($editora !== null && trim($editora) !== '') {
            $sql .= ' AND LOWER(editora) LIKE LOWER(:editora)';
            $params['editora'] = '%' . trim($editora) . '%';
        }

        if ($ano !== null && trim($ano) !== '') {
            $sql .= ' AND CAST(ano_publicacao AS TEXT) LIKE :ano';
            $params['ano'] = '%' . trim($ano) . '%';
        }

        $sql .= ' ORDER BY autor_nome ASC, titulo ASC';

        return $this->connection->fetchAllAssociative($sql, $params);
    }
}
