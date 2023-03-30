<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230325160223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE realisation_user (realisation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_973E0CB8B685E551 (realisation_id), INDEX IDX_973E0CB8A76ED395 (user_id), PRIMARY KEY(realisation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE realisation_user ADD CONSTRAINT FK_973E0CB8B685E551 FOREIGN KEY (realisation_id) REFERENCES realisation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realisation_user ADD CONSTRAINT FK_973E0CB8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation_user DROP FOREIGN KEY FK_973E0CB8B685E551');
        $this->addSql('ALTER TABLE realisation_user DROP FOREIGN KEY FK_973E0CB8A76ED395');
        $this->addSql('DROP TABLE realisation_user');
    }
}
