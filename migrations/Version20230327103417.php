<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327103417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_signale ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_signale ADD CONSTRAINT FK_EDFD22C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EDFD22C0A76ED395 ON service_signale (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_signale DROP FOREIGN KEY FK_EDFD22C0A76ED395');
        $this->addSql('DROP INDEX IDX_EDFD22C0A76ED395 ON service_signale');
        $this->addSql('ALTER TABLE service_signale DROP user_id');
    }
}
