<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327204246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_service_option (commande_id INT NOT NULL, service_option_id INT NOT NULL, INDEX IDX_A11A0A5C82EA2E54 (commande_id), INDEX IDX_A11A0A5CFF552725 (service_option_id), PRIMARY KEY(commande_id, service_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_service_option ADD CONSTRAINT FK_A11A0A5C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_service_option ADD CONSTRAINT FK_A11A0A5CFF552725 FOREIGN KEY (service_option_id) REFERENCES service_option (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_service_option DROP FOREIGN KEY FK_A11A0A5C82EA2E54');
        $this->addSql('ALTER TABLE commande_service_option DROP FOREIGN KEY FK_A11A0A5CFF552725');
        $this->addSql('DROP TABLE commande_service_option');
    }
}
