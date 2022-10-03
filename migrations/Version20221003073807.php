<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003073807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sondage AS SELECT id, title FROM sondage');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('CREATE TABLE sondage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO sondage (id, title) SELECT id, title FROM __temp__sondage');
        $this->addSql('DROP TABLE __temp__sondage');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7579C89F2B36786B ON sondage (title)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__sondage AS SELECT id, title FROM sondage');
        $this->addSql('DROP TABLE sondage');
        $this->addSql('CREATE TABLE sondage (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO sondage (id, title) SELECT id, title FROM __temp__sondage');
        $this->addSql('DROP TABLE __temp__sondage');
    }
}
