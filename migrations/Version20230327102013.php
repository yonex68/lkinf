<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327102013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_signale (id INT AUTO_INCREMENT NOT NULL, microservice_id INT DEFAULT NULL, message LONGTEXT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_EDFD22C0FDDA4EF4 (microservice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_signale ADD CONSTRAINT FK_EDFD22C0FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_signale DROP FOREIGN KEY FK_EDFD22C0FDDA4EF4');
        $this->addSql('DROP TABLE service_signale');
    }
}
