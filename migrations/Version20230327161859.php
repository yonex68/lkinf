<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327161859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE microservice_emplois_temps (microservice_id INT NOT NULL, emplois_temps_id INT NOT NULL, INDEX IDX_CFF3A806FDDA4EF4 (microservice_id), INDEX IDX_CFF3A806F2D90400 (emplois_temps_id), PRIMARY KEY(microservice_id, emplois_temps_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE microservice_emplois_temps ADD CONSTRAINT FK_CFF3A806FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_emplois_temps ADD CONSTRAINT FK_CFF3A806F2D90400 FOREIGN KEY (emplois_temps_id) REFERENCES emplois_temps (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice ADD offline TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE microservice_emplois_temps DROP FOREIGN KEY FK_CFF3A806FDDA4EF4');
        $this->addSql('ALTER TABLE microservice_emplois_temps DROP FOREIGN KEY FK_CFF3A806F2D90400');
        $this->addSql('DROP TABLE microservice_emplois_temps');
        $this->addSql('ALTER TABLE microservice DROP offline');
    }
}
