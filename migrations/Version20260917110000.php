<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260917110000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria a view utilizada pelo relatório de livros agrupados por autor.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE VIEW vw_relatorio_livros_por_autor AS
            SELECT
                autor.cod_au AS autor_codigo,
                autor.nome AS autor_nome,
                livro.cod_l AS livro_codigo,
                livro.titulo,
                livro.editora,
                livro.edicao,
                livro.ano_publicacao,
                livro.valor,
                COALESCE(STRING_AGG(DISTINCT assunto.descricao, ', ' ORDER BY assunto.descricao), '') AS assuntos
            FROM livro
            INNER JOIN livro_autor ON livro_autor.livro_cod_l = livro.cod_l
            INNER JOIN autor ON autor.cod_au = livro_autor.autor_cod_au
            LEFT JOIN livro_assunto ON livro_assunto.livro_cod_l = livro.cod_l
            LEFT JOIN assunto ON assunto.cod_as = livro_assunto.assunto_cod_as
            GROUP BY
                autor.cod_au,
                autor.nome,
                livro.cod_l,
                livro.titulo,
                livro.editora,
                livro.edicao,
                livro.ano_publicacao,
                livro.valor
            SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP VIEW vw_relatorio_livros_por_autor');
    }
}
