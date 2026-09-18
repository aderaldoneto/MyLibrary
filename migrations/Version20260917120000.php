<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260917120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cadastra 10 assuntos iniciais para o catálogo.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO assunto (descricao) VALUES
            ('Romance'),
            ('Fantasia'),
            ('Ficção Científica'),
            ('Suspense'),
            ('Terror'),
            ('Distopia'),
            ('Aventura'),
            ('Mistério / Policial'),
            ('Biografia'),
            ('Autoajuda')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM assunto WHERE descricao IN (
            'Romance',
            'Fantasia',
            'Ficção Científica',
            'Suspense',
            'Terror',
            'Distopia',
            'Aventura',
            'Mistério / Policial',
            'Biografia',
            'Autoajuda'
        )");
    }
}
