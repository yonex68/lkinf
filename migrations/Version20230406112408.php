<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406112408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, date DATETIME NOT NULL, heure_ouverture TIME NOT NULL, heure_cloture TIME NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_2CBACE2FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FED5CA9E6 FOREIGN KEY (service_id) REFERENCES microservice (id)');
        $this->addSql('ALTER TABLE emplois_temps ADD created DATETIME NOT NULL, ADD updated DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FED5CA9E6');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('ALTER TABLE emplois_temps DROP created, DROP updated');
    }
}
