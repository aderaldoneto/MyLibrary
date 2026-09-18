<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260917121000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cadastra 20 autores iniciais para o catálogo.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO autor (nome) VALUES
            ('William Shakespeare'),
            ('Miguel de Cervantes'),
            ('Liev Tolstói'),
            ('Charles Dickens'),
            ('Jane Austen'),
            ('Gabriel García Márquez'),
            ('Mark Twain'),
            ('Franz Kafka'),
            ('Agatha Christie'),
            ('Fiódor Dostoiévski'),
            ('George Orwell'),
            ('Virginia Woolf'),
            ('Haruki Murakami'),
            ('J.R.R. Tolkien'),
            ('Machado de Assis'),
            ('Clarice Lispector'),
            ('Jorge Amado'),
            ('Guimarães Rosa'),
            ('Graciliano Ramos'),
            ('Carlos Drummond de Andrade')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM autor WHERE nome IN (
            'William Shakespeare',
            'Miguel de Cervantes',
            'Liev Tolstói',
            'Charles Dickens',
            'Jane Austen',
            'Gabriel García Márquez',
            'Mark Twain',
            'Franz Kafka',
            'Agatha Christie',
            'Fiódor Dostoiévski',
            'George Orwell',
            'Virginia Woolf',
            'Haruki Murakami',
            'J.R.R. Tolkien',
            'Machado de Assis',
            'Clarice Lispector',
            'Jorge Amado',
            'Guimarães Rosa',
            'Graciliano Ramos',
            'Carlos Drummond de Andrade'
        )");
    }
}
