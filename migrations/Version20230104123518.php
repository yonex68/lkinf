<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104123518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE microservice_prix (microservice_id INT NOT NULL, prix_id INT NOT NULL, INDEX IDX_7F36493CFDDA4EF4 (microservice_id), INDEX IDX_7F36493C944722F2 (prix_id), PRIMARY KEY(microservice_id, prix_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prix (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tarif DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE microservice_prix ADD CONSTRAINT FK_7F36493CFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_prix ADD CONSTRAINT FK_7F36493C944722F2 FOREIGN KEY (prix_id) REFERENCES prix (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE microservice_prix DROP FOREIGN KEY FK_7F36493C944722F2');
        $this->addSql('DROP TABLE microservice_prix');
        $this->addSql('DROP TABLE prix');
    }
}
