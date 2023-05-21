<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521152104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historization (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, date DATETIME NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_E043559FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historization_file (id INT AUTO_INCREMENT NOT NULL, historization_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_529DC92FB8178326 (historization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subtype (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_556B25A2C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historization ADD CONSTRAINT FK_E043559FC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE historization_file ADD CONSTRAINT FK_529DC92FB8178326 FOREIGN KEY (historization_id) REFERENCES historization (id)');
        $this->addSql('ALTER TABLE subtype ADD CONSTRAINT FK_556B25A2C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historization DROP FOREIGN KEY FK_E043559FC54C8C93');
        $this->addSql('ALTER TABLE historization_file DROP FOREIGN KEY FK_529DC92FB8178326');
        $this->addSql('ALTER TABLE subtype DROP FOREIGN KEY FK_556B25A2C54C8C93');
        $this->addSql('DROP TABLE historization');
        $this->addSql('DROP TABLE historization_file');
        $this->addSql('DROP TABLE subtype');
        $this->addSql('DROP TABLE type');
    }
}
