<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317005128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE availability ADD COLUMN created DATETIME DEFAULT 0');
        $this->addSql('ALTER TABLE availability ADD COLUMN updated DATETIME DEFAULT 0');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created, updated FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, created DATETIME DEFAULT 0, updated DATETIME DEFAULT 0)');
        $this->addSql('INSERT INTO user (id, email, roles, password, created, updated) SELECT id, email, roles, password, created, updated FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__availability AS SELECT id, year, month, days, user_id FROM availability');
        $this->addSql('DROP TABLE availability');
        $this->addSql('CREATE TABLE availability (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, month INTEGER NOT NULL, days CLOB NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_3FB7A2BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO availability (id, year, month, days, user_id) SELECT id, year, month, days, user_id FROM __temp__availability');
        $this->addSql('DROP TABLE __temp__availability');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFA76ED395 ON availability (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, created, updated FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, created DATETIME DEFAULT \'0\', updated DATETIME DEFAULT \'0\')');
        $this->addSql('INSERT INTO user (id, email, roles, password, created, updated) SELECT id, email, roles, password, created, updated FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
