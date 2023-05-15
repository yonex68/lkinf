<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514153014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE microservice_realisation DROP FOREIGN KEY FK_C50CDC7EFDDA4EF4');
        $this->addSql('ALTER TABLE microservice_realisation DROP FOREIGN KEY FK_C50CDC7EB685E551');
        $this->addSql('DROP TABLE microservice_realisation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE microservice_realisation (microservice_id INT NOT NULL, realisation_id INT NOT NULL, INDEX IDX_C50CDC7EFDDA4EF4 (microservice_id), INDEX IDX_C50CDC7EB685E551 (realisation_id), PRIMARY KEY(microservice_id, realisation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE microservice_realisation ADD CONSTRAINT FK_C50CDC7EFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_realisation ADD CONSTRAINT FK_C50CDC7EB685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) ON DELETE CASCADE');
    }
}
