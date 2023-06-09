<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520154747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, stripe_id INT DEFAULT NULL, user_id INT DEFAULT NULL, statut TINYINT(1) NOT NULL, is_active TINYINT(1) DEFAULT NULL, is_canceled TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_351268BB3F1B1098 (stripe_id), UNIQUE INDEX UNIQ_351268BBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, client_id INT DEFAULT NULL, microservice_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_8F91ABF0858C065E (vendeur_id), INDEX IDX_8F91ABF019EB6921 (client_id), INDEX IDX_8F91ABF0FDDA4EF4 (microservice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis_reponse (id INT AUTO_INCREMENT NOT NULL, avis_id INT DEFAULT NULL, vendeur_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, created DATETIME NOT NULL, INDEX IDX_74B54EC1197E709F (avis_id), INDEX IDX_74B54EC1858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caisse (id INT AUTO_INCREMENT NOT NULL, solde_disponible DOUBLE PRECISION NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, hex_color VARCHAR(7) NOT NULL, image VARCHAR(255) DEFAULT NULL, icone VARCHAR(255) DEFAULT NULL, position INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, microservice_id INT DEFAULT NULL, client_id INT DEFAULT NULL, vendeur_id INT DEFAULT NULL, destinataire_id INT DEFAULT NULL, rapport_id INT DEFAULT NULL, pack_id INT DEFAULT NULL, avis_id INT DEFAULT NULL, offre VARCHAR(255) DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, validate TINYINT(1) NOT NULL, deliver TINYINT(1) NOT NULL, cancel TINYINT(1) NOT NULL, deliver_at DATETIME DEFAULT NULL, cancel_at DATETIME DEFAULT NULL, validate_at DATETIME DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, confirmation_client TINYINT(1) NOT NULL, lu TINYINT(1) NOT NULL, rapport_validate TINYINT(1) DEFAULT NULL, rapport_validate_at DATETIME DEFAULT NULL, payment_intent VARCHAR(255) DEFAULT NULL, disponibilite VARCHAR(255) DEFAULT NULL, reservation_date VARCHAR(255) DEFAULT NULL, reservation_start_at TIME DEFAULT NULL, reservation_end_at TIME DEFAULT NULL, payed TINYINT(1) DEFAULT NULL, taux_horaire VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6EEAA67DFDDA4EF4 (microservice_id), INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D858C065E (vendeur_id), INDEX IDX_6EEAA67DA4F84F6E (destinataire_id), UNIQUE INDEX UNIQ_6EEAA67D1DFBCC46 (rapport_id), INDEX IDX_6EEAA67D1919B217 (pack_id), INDEX IDX_6EEAA67D197E709F (avis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_service_option (commande_id INT NOT NULL, service_option_id INT NOT NULL, INDEX IDX_A11A0A5C82EA2E54 (commande_id), INDEX IDX_A11A0A5CFF552725 (service_option_id), PRIMARY KEY(commande_id, service_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, commande_id INT NOT NULL, contenu LONGTEXT NOT NULL, lu TINYINT(1) NOT NULL, created DATETIME NOT NULL, INDEX IDX_400642DFA76ED395 (user_id), INDEX IDX_400642DF82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, microservice_id INT DEFAULT NULL, user1_id INT NOT NULL, user2_id INT NOT NULL, last_message_id INT DEFAULT NULL, sender_id INT DEFAULT NULL, terminee TINYINT(1) NOT NULL, created DATETIME NOT NULL, INDEX IDX_8A8E26E9FDDA4EF4 (microservice_id), INDEX IDX_8A8E26E956AE248B (user1_id), INDEX IDX_8A8E26E9441B8B65 (user2_id), INDEX IDX_8A8E26E9BA0E79C3 (last_message_id), INDEX IDX_8A8E26E9F624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilite (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, heure_ouverture TIME NOT NULL, heure_cloture TIME NOT NULL, jours LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_2CBACE2FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emplois_temps (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, heure_ouverture TIME NOT NULL, heure_cloture TIME NOT NULL, jours LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_551C3168858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favoris (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, microservice_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_8933C43219EB6921 (client_id), INDEX IDX_8933C432FDDA4EF4 (microservice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galerie (id INT AUTO_INCREMENT NOT NULL, image1 VARCHAR(255) DEFAULT NULL, image2 VARCHAR(255) DEFAULT NULL, image3 VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, microservice_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6A2CA10CFDDA4EF4 (microservice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, auteur_id INT NOT NULL, destinataire_id INT NOT NULL, commande_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, lu TINYINT(1) NOT NULL, created DATETIME NOT NULL, INDEX IDX_B6BD307F9AC0396 (conversation_id), INDEX IDX_B6BD307F60BB6FE6 (auteur_id), INDEX IDX_B6BD307FA4F84F6E (destinataire_id), INDEX IDX_B6BD307F82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE microservice (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, online TINYINT(1) DEFAULT NULL, delai INT DEFAULT NULL, prix_mastering DOUBLE PRECISION NOT NULL, prix_mixage DOUBLE PRECISION NOT NULL, prix_beatmaking DOUBLE PRECISION NOT NULL, promo TINYINT(1) NOT NULL, prix_composition DOUBLE PRECISION DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, offline TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_770EA0AF858C065E (vendeur_id), INDEX IDX_770EA0AFBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE microservice_emplois_temps (microservice_id INT NOT NULL, emplois_temps_id INT NOT NULL, INDEX IDX_CFF3A806FDDA4EF4 (microservice_id), INDEX IDX_CFF3A806F2D90400 (emplois_temps_id), PRIMARY KEY(microservice_id, emplois_temps_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tarif DOUBLE PRECISION NOT NULL, image_name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, couverture VARCHAR(255) DEFAULT NULL, online TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_categorie (offre_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_15F57ECB4CC8505A (offre_id), INDEX IDX_15F57ECBBCF5E72D (categorie_id), PRIMARY KEY(offre_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portefeuille (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, solde_disponible DOUBLE PRECISION NOT NULL, solde_en_cours DOUBLE PRECISION DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_2955FFFE858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prix (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tarif DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, fichier VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_BE34A09C82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, microservice_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, plateforme VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_EAA5610E858C065E (vendeur_id), INDEX IDX_EAA5610EFDDA4EF4 (microservice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remboursement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, vendeur_id INT DEFAULT NULL, motif LONGTEXT NOT NULL, montant DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, reponse LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_C0C0D9EFA76ED395 (user_id), INDEX IDX_C0C0D9EF82EA2E54 (commande_id), INDEX IDX_C0C0D9EF858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retrait (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, mode_paiement VARCHAR(255) NOT NULL, nomsur_carte VARCHAR(255) DEFAULT NULL, numero_carte VARCHAR(255) DEFAULT NULL, date_expiration DATETIME DEFAULT NULL, adresse_paypal VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, reponse LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_D9846A51858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_option (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, delai INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_option_microservice (service_option_id INT NOT NULL, microservice_id INT NOT NULL, INDEX IDX_7AB32DF9FF552725 (service_option_id), INDEX IDX_7AB32DF9FDDA4EF4 (microservice_id), PRIMARY KEY(service_option_id, microservice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_signale (id INT AUTO_INCREMENT NOT NULL, microservice_id INT DEFAULT NULL, user_id INT NOT NULL, message LONGTEXT NOT NULL, lu TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_EDFD22C0FDDA4EF4 (microservice_id), INDEX IDX_EDFD22C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stripe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, tarif DOUBLE PRECISION NOT NULL, stripe_key VARCHAR(255) NOT NULL, hex_color VARCHAR(7) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivis (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, vendeur_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_6627ED7019EB6921 (client_id), INDEX IDX_6627ED70858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, password VARCHAR(255) NOT NULL, compte VARCHAR(255) NOT NULL, apropos LONGTEXT DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', is_verified TINYINT(1) NOT NULL, name_url VARCHAR(255) NOT NULL, profession VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, reseau_avatar VARCHAR(500) DEFAULT NULL, facebook_id INT DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, couverture VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, lieu_prestation VARCHAR(255) DEFAULT NULL, home_studio TINYINT(1) DEFAULT NULL, end_register TINYINT(1) DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, use_pseudo TINYINT(1) DEFAULT NULL, instagram_id VARCHAR(255) DEFAULT NULL, iban VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, paypal VARCHAR(255) DEFAULT NULL, stripe VARCHAR(255) DEFAULT NULL, siret VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, receved_paiement TINYINT(1) DEFAULT NULL, stripe_account_id VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB3F1B1098 FOREIGN KEY (stripe_id) REFERENCES stripe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF019EB6921 FOREIGN KEY (client_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis_reponse ADD CONSTRAINT FK_74B54EC1197E709F FOREIGN KEY (avis_id) REFERENCES avis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE avis_reponse ADD CONSTRAINT FK_74B54EC1858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D1919B217 FOREIGN KEY (pack_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
        $this->addSql('ALTER TABLE commande_service_option ADD CONSTRAINT FK_A11A0A5C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_service_option ADD CONSTRAINT FK_A11A0A5CFF552725 FOREIGN KEY (service_option_id) REFERENCES service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_message ADD CONSTRAINT FK_400642DFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_message ADD CONSTRAINT FK_400642DF82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E956AE248B FOREIGN KEY (user1_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9441B8B65 FOREIGN KEY (user2_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9F624B39D FOREIGN KEY (sender_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE disponibilite ADD CONSTRAINT FK_2CBACE2FED5CA9E6 FOREIGN KEY (service_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE emplois_temps ADD CONSTRAINT FK_551C3168858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43219EB6921 FOREIGN KEY (client_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice ADD CONSTRAINT FK_770EA0AF858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice ADD CONSTRAINT FK_770EA0AFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_emplois_temps ADD CONSTRAINT FK_CFF3A806FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE microservice_emplois_temps ADD CONSTRAINT FK_CFF3A806F2D90400 FOREIGN KEY (emplois_temps_id) REFERENCES emplois_temps (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_categorie ADD CONSTRAINT FK_15F57ECB4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_categorie ADD CONSTRAINT FK_15F57ECBBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE portefeuille ADD CONSTRAINT FK_2955FFFE858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EFDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE retrait ADD CONSTRAINT FK_D9846A51858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_option_microservice ADD CONSTRAINT FK_7AB32DF9FF552725 FOREIGN KEY (service_option_id) REFERENCES service_option (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_option_microservice ADD CONSTRAINT FK_7AB32DF9FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_signale ADD CONSTRAINT FK_EDFD22C0FDDA4EF4 FOREIGN KEY (microservice_id) REFERENCES microservice (id)');
        $this->addSql('ALTER TABLE service_signale ADD CONSTRAINT FK_EDFD22C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE suivis ADD CONSTRAINT FK_6627ED7019EB6921 FOREIGN KEY (client_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE suivis ADD CONSTRAINT FK_6627ED70858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB3F1B1098');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA76ED395');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0858C065E');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF019EB6921');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0FDDA4EF4');
        $this->addSql('ALTER TABLE avis_reponse DROP FOREIGN KEY FK_74B54EC1197E709F');
        $this->addSql('ALTER TABLE avis_reponse DROP FOREIGN KEY FK_74B54EC1858C065E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFDDA4EF4');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D858C065E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA4F84F6E');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1DFBCC46');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D1919B217');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D197E709F');
        $this->addSql('ALTER TABLE commande_service_option DROP FOREIGN KEY FK_A11A0A5C82EA2E54');
        $this->addSql('ALTER TABLE commande_service_option DROP FOREIGN KEY FK_A11A0A5CFF552725');
        $this->addSql('ALTER TABLE commande_message DROP FOREIGN KEY FK_400642DFA76ED395');
        $this->addSql('ALTER TABLE commande_message DROP FOREIGN KEY FK_400642DF82EA2E54');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9FDDA4EF4');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E956AE248B');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9441B8B65');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9BA0E79C3');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9F624B39D');
        $this->addSql('ALTER TABLE disponibilite DROP FOREIGN KEY FK_2CBACE2FED5CA9E6');
        $this->addSql('ALTER TABLE emplois_temps DROP FOREIGN KEY FK_551C3168858C065E');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C43219EB6921');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432FDDA4EF4');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CFDDA4EF4');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F60BB6FE6');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA4F84F6E');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F82EA2E54');
        $this->addSql('ALTER TABLE microservice DROP FOREIGN KEY FK_770EA0AF858C065E');
        $this->addSql('ALTER TABLE microservice DROP FOREIGN KEY FK_770EA0AFBCF5E72D');
        $this->addSql('ALTER TABLE microservice_emplois_temps DROP FOREIGN KEY FK_CFF3A806FDDA4EF4');
        $this->addSql('ALTER TABLE microservice_emplois_temps DROP FOREIGN KEY FK_CFF3A806F2D90400');
        $this->addSql('ALTER TABLE offre_categorie DROP FOREIGN KEY FK_15F57ECB4CC8505A');
        $this->addSql('ALTER TABLE offre_categorie DROP FOREIGN KEY FK_15F57ECBBCF5E72D');
        $this->addSql('ALTER TABLE portefeuille DROP FOREIGN KEY FK_2955FFFE858C065E');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C82EA2E54');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610E858C065E');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610EFDDA4EF4');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EFA76ED395');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF82EA2E54');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF858C065E');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE retrait DROP FOREIGN KEY FK_D9846A51858C065E');
        $this->addSql('ALTER TABLE service_option_microservice DROP FOREIGN KEY FK_7AB32DF9FF552725');
        $this->addSql('ALTER TABLE service_option_microservice DROP FOREIGN KEY FK_7AB32DF9FDDA4EF4');
        $this->addSql('ALTER TABLE service_signale DROP FOREIGN KEY FK_EDFD22C0FDDA4EF4');
        $this->addSql('ALTER TABLE service_signale DROP FOREIGN KEY FK_EDFD22C0A76ED395');
        $this->addSql('ALTER TABLE suivis DROP FOREIGN KEY FK_6627ED7019EB6921');
        $this->addSql('ALTER TABLE suivis DROP FOREIGN KEY FK_6627ED70858C065E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BCF5E72D');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE avis_reponse');
        $this->addSql('DROP TABLE caisse');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_service_option');
        $this->addSql('DROP TABLE commande_message');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE disponibilite');
        $this->addSql('DROP TABLE emplois_temps');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE microservice');
        $this->addSql('DROP TABLE microservice_emplois_temps');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_categorie');
        $this->addSql('DROP TABLE portefeuille');
        $this->addSql('DROP TABLE prix');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE remboursement');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE retrait');
        $this->addSql('DROP TABLE service_option');
        $this->addSql('DROP TABLE service_option_microservice');
        $this->addSql('DROP TABLE service_signale');
        $this->addSql('DROP TABLE stripe');
        $this->addSql('DROP TABLE suivis');
        $this->addSql('DROP TABLE user');
    }
}
