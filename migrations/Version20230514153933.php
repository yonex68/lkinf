<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514153933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation ADD microservice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id)');
        $this->addSql('CREATE INDEX IDX_EAA5610EFDDA4EF4 ON realisation (microservice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610EFDDA4EF4');
        $this->addSql('DROP INDEX IDX_EAA5610EFDDA4EF4 ON realisation');
        $this->addSql('ALTER TABLE realisation DROP microservice_id');
    }
}
