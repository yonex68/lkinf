<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516153930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_reponse ADD vendeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avis_reponse ADD CONSTRAINT FK_74B54EC1858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_74B54EC1858C065E ON avis_reponse (vendeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_reponse DROP FOREIGN KEY FK_74B54EC1858C065E');
        $this->addSql('DROP INDEX IDX_74B54EC1858C065E ON avis_reponse');
        $this->addSql('ALTER TABLE avis_reponse DROP vendeur_id');
    }
}
