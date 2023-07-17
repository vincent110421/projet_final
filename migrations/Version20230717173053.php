<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717173053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE objective ADD training_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE objective ADD CONSTRAINT FK_B996F101BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B996F101BEFD98D1 ON objective (training_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE objective DROP FOREIGN KEY FK_B996F101BEFD98D1');
        $this->addSql('DROP INDEX UNIQ_B996F101BEFD98D1 ON objective');
        $this->addSql('ALTER TABLE objective DROP training_id');
    }
}
