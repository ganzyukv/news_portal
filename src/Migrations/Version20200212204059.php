<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212204059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE category ADD COLUMN slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, short_description, body, image, publication_date, category_id FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, short_description CLOB DEFAULT NULL COLLATE BINARY, body CLOB DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, publication_date DATETIME DEFAULT NULL, category_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO post (id, title, short_description, body, image, publication_date, category_id) SELECT id, title, short_description, body, image, publication_date, category_id FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__category AS SELECT id, title FROM category');
        $this->addSql('DROP TABLE category');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO category (id, title) SELECT id, title FROM __temp__category');
        $this->addSql('DROP TABLE __temp__category');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, short_description, body, image, publication_date, category_id FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, short_description CLOB DEFAULT NULL, body CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, publication_date DATETIME DEFAULT NULL, category_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO post (id, title, short_description, body, image, publication_date, category_id) SELECT id, title, short_description, body, image, publication_date, category_id FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}
