<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406114621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE microservice_planning DROP FOREIGN KEY FK_2D1116033D865311');
        $this->addSql('ALTER TABLE microservice_planning DROP FOREIGN KEY FK_2D111603FDDA4EF4');
        $this->addSql('DROP TABLE microservice_planning');
        $this->addSql('DROP TABLE planning');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE microservice_planning (microservice_id INT NOT NULL, planning_id INT NOT NULL, INDEX IDX_2D1116033D865311 (planning_id), INDEX IDX_2D111603FDDA4EF4 (microservice_id), PRIMARY KEY(microservice_id, planning_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, jour VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, heure_ouverture TIME NOT NULL, heure_cloture TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE microservice_planning ADD CONSTRAINT FK_2D1116033D865311 FOREIGN KEY (planning_id) REFERENCES planning (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_planning ADD CONSTRAINT FK_2D111603FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
    }
}
