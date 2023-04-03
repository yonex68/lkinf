<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403123348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remboursement ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_C0C0D9EF82EA2E54 ON remboursement (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF82EA2E54');
        $this->addSql('DROP INDEX IDX_C0C0D9EF82EA2E54 ON remboursement');
        $this->addSql('ALTER TABLE remboursement DROP commande_id');
    }
}
