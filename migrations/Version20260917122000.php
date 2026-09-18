<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260917122000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cadastra 30 livros com relacionamento com autores e assuntos.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO livro (titulo, editora, edicao, ano_publicacao, valor) VALUES
            ('Livro 01', 'Editora Nova', 1, '2020', 4200),
            ('Livro 02', 'Editora Sol', 2, '2021', 5300),
            ('Livro 03', 'Editora Aurora', 1, '2019', 3900),
            ('Livro 04', 'Editora Verde', 3, '2022', 6100),
            ('Livro 05', 'Editora Centro', 1, '2018', 4700),
            ('Livro 06', 'Editora Mestre', 4, '2023', 7600),
            ('Livro 07', 'Editora Lumen', 2, '2021', 5600),
            ('Livro 08', 'Editora Ponto', 1, '2020', 4300),
            ('Livro 09', 'Editora Atlas', 3, '2022', 6900),
            ('Livro 10', 'Editora Futura', 2, '2019', 5100),
            ('Livro 11', 'Editora Saber', 1, '2024', 7350),
            ('Livro 12', 'Editora Branca', 5, '2020', 8200),
            ('Livro 13', 'Editora Nova', 2, '2021', 4900),
            ('Livro 14', 'Editora Atlas', 1, '2017', 3500),
            ('Livro 15', 'Editora Sol', 4, '2023', 7800),
            ('Livro 16', 'Editora Aurora', 2, '2018', 4800),
            ('Livro 17', 'Editora Lume', 1, '2022', 4400),
            ('Livro 18', 'Editora Horizonte', 3, '2021', 6800),
            ('Livro 19', 'Editora Canto', 2, '2020', 5300),
            ('Livro 20', 'Editora Mente', 1, '2024', 7100),
            ('Livro 21', 'Editora Risco', 2, '2022', 5900),
            ('Livro 22', 'Editora Prisma', 1, '2019', 3900),
            ('Livro 23', 'Editora Vale', 3, '2023', 7200),
            ('Livro 24', 'Editora Viver', 4, '2021', 8100),
            ('Livro 25', 'Editora Ideal', 1, '2020', 4200),
            ('Livro 26', 'Editora Luz', 2, '2022', 5700),
            ('Livro 27', 'Editora Tempo', 1, '2023', 6100),
            ('Livro 28', 'Editora Raiz', 3, '2018', 4700),
            ('Livro 29', 'Editora Pulse', 2, '2024', 7600),
            ('Livro 30', 'Editora Nobre', 5, '2021', 9300)");

        $this->addSql("INSERT INTO livro_autor (livro_cod_l, autor_cod_au) VALUES
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 01'), 1),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 02'), 2),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 03'), 3),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 04'), 4),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 05'), 5),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 06'), 6),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 07'), 7),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 08'), 8),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 09'), 9),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 10'), 10),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 11'), 11),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 12'), 12),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 13'), 13),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 14'), 14),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 15'), 15),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 16'), 16),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 17'), 17),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 18'), 18),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 19'), 19),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 20'), 20),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 21'), 1),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 22'), 2),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 23'), 3),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 24'), 4),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 25'), 5),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 26'), 6),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 27'), 7),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 28'), 8),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 29'), 9),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 30'), 10)");

        $this->addSql("INSERT INTO livro_assunto (livro_cod_l, assunto_cod_as) VALUES
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 01'), 1),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 02'), 2),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 03'), 3),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 04'), 4),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 05'), 5),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 06'), 6),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 07'), 7),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 08'), 8),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 09'), 9),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 10'), 10),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 11'), 1),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 12'), 2),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 13'), 3),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 14'), 4),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 15'), 5),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 16'), 6),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 17'), 7),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 18'), 8),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 19'), 9),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 20'), 10),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 21'), 1),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 22'), 2),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 23'), 3),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 24'), 4),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 25'), 5),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 26'), 6),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 27'), 7),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 28'), 8),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 29'), 9),
            ((SELECT cod_l FROM livro WHERE titulo = 'Livro 30'), 10)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM livro_assunto WHERE livro_cod_l IN (
            SELECT cod_l FROM livro WHERE titulo IN (
                'Livro 01', 'Livro 02', 'Livro 03', 'Livro 04', 'Livro 05',
                'Livro 06', 'Livro 07', 'Livro 08', 'Livro 09', 'Livro 10',
                'Livro 11', 'Livro 12', 'Livro 13', 'Livro 14', 'Livro 15',
                'Livro 16', 'Livro 17', 'Livro 18', 'Livro 19', 'Livro 20',
                'Livro 21', 'Livro 22', 'Livro 23', 'Livro 24', 'Livro 25',
                'Livro 26', 'Livro 27', 'Livro 28', 'Livro 29', 'Livro 30'
            )
        )");

        $this->addSql("DELETE FROM livro_autor WHERE livro_cod_l IN (
            SELECT cod_l FROM livro WHERE titulo IN (
                'Livro 01', 'Livro 02', 'Livro 03', 'Livro 04', 'Livro 05',
                'Livro 06', 'Livro 07', 'Livro 08', 'Livro 09', 'Livro 10',
                'Livro 11', 'Livro 12', 'Livro 13', 'Livro 14', 'Livro 15',
                'Livro 16', 'Livro 17', 'Livro 18', 'Livro 19', 'Livro 20',
                'Livro 21', 'Livro 22', 'Livro 23', 'Livro 24', 'Livro 25',
                'Livro 26', 'Livro 27', 'Livro 28', 'Livro 29', 'Livro 30'
            )
        )");

        $this->addSql("DELETE FROM livro WHERE titulo IN (
            'Livro 01', 'Livro 02', 'Livro 03', 'Livro 04', 'Livro 05',
            'Livro 06', 'Livro 07', 'Livro 08', 'Livro 09', 'Livro 10',
            'Livro 11', 'Livro 12', 'Livro 13', 'Livro 14', 'Livro 15',
            'Livro 16', 'Livro 17', 'Livro 18', 'Livro 19', 'Livro 20',
            'Livro 21', 'Livro 22', 'Livro 23', 'Livro 24', 'Livro 25',
            'Livro 26', 'Livro 27', 'Livro 28', 'Livro 29', 'Livro 30'
        )");
    }
}
