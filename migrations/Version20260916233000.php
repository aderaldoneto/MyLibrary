<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260916233000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Cria usuário padrão para login da aplicação';
    }

    public function up(Schema $schema): void
    {
        $hashedPassword = password_hash('admin', PASSWORD_BCRYPT);

        $this->addSql(
            'INSERT INTO users 
                (name, last_name, email, password, created_at, updated_at, deleted_at) 
            VALUES 
                (:name, :last_name, :email, :password, :created_at, :updated_at, :deleted_at)',
            [
                'name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => $hashedPassword,
                'created_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'updated_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'deleted_at' => null,
            ]
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM users WHERE email = 'admin@gmail.com'");
    }
}
