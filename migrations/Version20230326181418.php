<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230326181418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emplois_temps (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, jours VARCHAR(255) NOT NULL, heure_debut TIME NOT NULL, heure_cloture TIME NOT NULL, ordre SMALLINT NOT NULL, INDEX IDX_551C3168858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emplois_temps ADD CONSTRAINT FK_551C3168858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emplois_temps DROP FOREIGN KEY FK_551C3168858C065E');
        $this->addSql('DROP TABLE emplois_temps');
    }
}
