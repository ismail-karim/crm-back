<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521181232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historization ADD subtype_id INT NOT NULL');
        $this->addSql('ALTER TABLE historization ADD CONSTRAINT FK_E043559F8E2E245C FOREIGN KEY (subtype_id) REFERENCES subtype (id)');
        $this->addSql('CREATE INDEX IDX_E043559F8E2E245C ON historization (subtype_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historization DROP FOREIGN KEY FK_E043559F8E2E245C');
        $this->addSql('DROP INDEX IDX_E043559F8E2E245C ON historization');
        $this->addSql('ALTER TABLE historization DROP subtype_id');
    }
}
