<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317112426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, date DATETIME DEFAULT NULL, status BOOLEAN NOT NULL, created DATETIME DEFAULT 0, updated DATETIME DEFAULT 0, user_id INTEGER NOT NULL, user_group_id INTEGER NOT NULL, CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3BAE0AA71ED93D47 FOREIGN KEY (user_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A76ED395 ON event (user_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA71ED93D47 ON event (user_group_id)');
        $this->addSql('CREATE TABLE "group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created DATETIME DEFAULT 0, updated DATETIME DEFAULT 0, user_id INTEGER NOT NULL, CONSTRAINT FK_6DC044C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6DC044C5A76ED395 ON "group" (user_id)');
        $this->addSql('CREATE TABLE group_user (group_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(group_id, user_id), CONSTRAINT FK_A4C98D39FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A4C98D39A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A4C98D39FE54D947 ON group_user (group_id)');
        $this->addSql('CREATE INDEX IDX_A4C98D39A76ED395 ON group_user (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__availability AS SELECT id, year, month, days, user_id, created, updated FROM availability');
        $this->addSql('DROP TABLE availability');
        $this->addSql('CREATE TABLE availability (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, month INTEGER NOT NULL, days CLOB NOT NULL, user_id INTEGER NOT NULL, created DATETIME DEFAULT 0, updated DATETIME DEFAULT 0, CONSTRAINT FK_3FB7A2BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO availability (id, year, month, days, user_id, created, updated) SELECT id, year, month, days, user_id, created, updated FROM __temp__availability');
        $this->addSql('DROP TABLE __temp__availability');
        $this->addSql('CREATE INDEX IDX_3FB7A2BFA76ED395 ON availability (user_id)');
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
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE group_user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__availability AS SELECT id, year, month, days, created, updated, user_id FROM availability');
        $this->addSql('DROP TABLE availability');
        $this->addSql('CREATE TABLE availability (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, month INTEGER NOT NULL, days CLOB NOT NULL, created DATETIME DEFAULT \'0\', updated DATETIME DEFAULT \'0\', user_id INTEGER NOT NULL, CONSTRAINT FK_3FB7A2BFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO availability (id, year, month, days, created, updated, user_id) SELECT id, year, month, days, created, updated, user_id FROM __temp__availability');
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
