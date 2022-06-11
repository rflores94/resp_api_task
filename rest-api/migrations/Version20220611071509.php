<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611071509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, created_data, updated_data, done FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_data DATETIME NOT NULL, updated_data DATETIME NOT NULL, done BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO task (id, title, created_data, updated_data, done) SELECT id, title, created_data, updated_data, done FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__task AS SELECT id, title, created_data, updated_data, done FROM task');
        $this->addSql('DROP TABLE task');
        $this->addSql('CREATE TABLE task (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_data DATE NOT NULL, updated_data DATETIME NOT NULL, done BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO task (id, title, created_data, updated_data, done) SELECT id, title, created_data, updated_data, done FROM __temp__task');
        $this->addSql('DROP TABLE __temp__task');
    }
}
