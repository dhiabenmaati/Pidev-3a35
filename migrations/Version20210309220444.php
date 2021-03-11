<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309220444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, date_creer DATE NOT NULL, date_expedirer DATE DEFAULT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE DetailProduit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_BE9F605682EA2E54 (commande_id), INDEX IDX_BE9F6056F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom_prod VARCHAR(255) NOT NULL, desc_prod VARCHAR(255) NOT NULL, prix_prod DOUBLE PRECISION NOT NULL, qte_prod INT NOT NULL, image_prod VARCHAR(255) NOT NULL, valid_prod TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE DetailProduit ADD CONSTRAINT FK_BE9F605682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE DetailProduit ADD CONSTRAINT FK_BE9F6056F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE DetailProduit DROP FOREIGN KEY FK_BE9F605682EA2E54');
        $this->addSql('ALTER TABLE DetailProduit DROP FOREIGN KEY FK_BE9F6056F347EFB');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE DetailProduit');
        $this->addSql('DROP TABLE produit');
    }
}