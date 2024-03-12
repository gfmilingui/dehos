<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220805194353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE benne (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', numero_serie VARCHAR(255) NOT NULL, label VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) NOT NULL, date_livraison DATETIME DEFAULT NULL, capacite DOUBLE PRECISION NOT NULL, capacite_unite VARCHAR(255) NOT NULL, statut_workflow VARCHAR(255) NOT NULL, INDEX IDX_ADC7E1D5F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bon_sortie (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reference VARCHAR(255) DEFAULT NULL, nom_fourgon_chauffeur VARCHAR(255) DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, date_sortie DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bon_sortie_benne (bon_sortie_id INT NOT NULL, benne_id INT NOT NULL, INDEX IDX_624CDF9C5BDB77E8 (bon_sortie_id), INDEX IDX_624CDF9CAF66A7F8 (benne_id), PRIMARY KEY(bon_sortie_id, benne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, client_categorie_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', raison_sociale VARCHAR(255) NOT NULL, quartier VARCHAR(255) NOT NULL, fax VARCHAR(255) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, nombre_lits DOUBLE PRECISION DEFAULT NULL, numero_identification_sociale VARCHAR(255) DEFAULT NULL, internet VARCHAR(255) DEFAULT NULL, num_tel VARCHAR(255) NOT NULL, INDEX IDX_C7440455DFF452C (client_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_categorie (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nom VARCHAR(255) NOT NULL, label VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', titre_contrat VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, numero VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_6034999319EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, site_id INT DEFAULT NULL, bon_sortie_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', nombre_bennes INT NOT NULL, statut VARCHAR(255) NOT NULL, date DATETIME DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, INDEX IDX_2694D7A519EB6921 (client_id), INDEX IDX_2694D7A5F6BD1646 (site_id), UNIQUE INDEX UNIQ_2694D7A55BDB77E8 (bon_sortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, contrat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', quartier VARCHAR(255) NOT NULL, nombre_bennes INT NOT NULL, INDEX IDX_694309E419EB6921 (client_id), INDEX IDX_694309E41823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suivi_retour (id INT AUTO_INCREMENT NOT NULL, bon_sortie_id INT DEFAULT NULL, benne_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_retour_benne DATETIME DEFAULT NULL, pesee_agent DOUBLE PRECISION DEFAULT NULL, pesee_client DOUBLE PRECISION DEFAULT NULL, remarques LONGTEXT DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_4FABAE735BDB77E8 (bon_sortie_id), INDEX IDX_4FABAE73AF66A7F8 (benne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, bon_sortie_id INT DEFAULT NULL, benne_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', statut VARCHAR(255) NOT NULL, date_reception DATETIME DEFAULT NULL, date_mise_traitement DATETIME DEFAULT NULL, date_fin_traitement DATETIME DEFAULT NULL, expedition_nettoyage VARCHAR(255) DEFAULT NULL, expedition_retour_stock VARCHAR(255) DEFAULT NULL, remarques LONGTEXT DEFAULT NULL, INDEX IDX_2A356D275BDB77E8 (bon_sortie_id), INDEX IDX_2A356D27AF66A7F8 (benne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_enabled TINYINT(1) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, team VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE benne ADD CONSTRAINT FK_ADC7E1D5F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE bon_sortie_benne ADD CONSTRAINT FK_624CDF9C5BDB77E8 FOREIGN KEY (bon_sortie_id) REFERENCES bon_sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bon_sortie_benne ADD CONSTRAINT FK_624CDF9CAF66A7F8 FOREIGN KEY (benne_id) REFERENCES benne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455DFF452C FOREIGN KEY (client_categorie_id) REFERENCES client_categorie (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_6034999319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A55BDB77E8 FOREIGN KEY (bon_sortie_id) REFERENCES bon_sortie (id)');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E41823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE suivi_retour ADD CONSTRAINT FK_4FABAE735BDB77E8 FOREIGN KEY (bon_sortie_id) REFERENCES bon_sortie (id)');
        $this->addSql('ALTER TABLE suivi_retour ADD CONSTRAINT FK_4FABAE73AF66A7F8 FOREIGN KEY (benne_id) REFERENCES benne (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D275BDB77E8 FOREIGN KEY (bon_sortie_id) REFERENCES bon_sortie (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D27AF66A7F8 FOREIGN KEY (benne_id) REFERENCES benne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bon_sortie_benne DROP FOREIGN KEY FK_624CDF9CAF66A7F8');
        $this->addSql('ALTER TABLE suivi_retour DROP FOREIGN KEY FK_4FABAE73AF66A7F8');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D27AF66A7F8');
        $this->addSql('ALTER TABLE bon_sortie_benne DROP FOREIGN KEY FK_624CDF9C5BDB77E8');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A55BDB77E8');
        $this->addSql('ALTER TABLE suivi_retour DROP FOREIGN KEY FK_4FABAE735BDB77E8');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D275BDB77E8');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_6034999319EB6921');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A519EB6921');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E419EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455DFF452C');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E41823061F');
        $this->addSql('ALTER TABLE benne DROP FOREIGN KEY FK_ADC7E1D5F6BD1646');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5F6BD1646');
        $this->addSql('DROP TABLE benne');
        $this->addSql('DROP TABLE bon_sortie');
        $this->addSql('DROP TABLE bon_sortie_benne');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_categorie');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE suivi_retour');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
