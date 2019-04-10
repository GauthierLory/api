<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410153908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, modified_date DATETIME NOT NULL, INDEX IDX_EDBFD5ECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_modif (id INT AUTO_INCREMENT NOT NULL, historique_id INT NOT NULL, table_modif VARCHAR(180) NOT NULL, champ_modif VARCHAR(180) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, record_id INT NOT NULL, UNIQUE INDEX UNIQ_D5750EB86128735E (historique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique_modif ADD CONSTRAINT FK_D5750EB86128735E FOREIGN KEY (historique_id) REFERENCES historique (id)');
        $this->addSql('ALTER TABLE article ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_794381C64584665A');
        $this->addSql('DROP INDEX IDX_794381C64584665A ON comment');
        $this->addSql('ALTER TABLE comment ADD created_at DATETIME NOT NULL, CHANGE product_id article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_9474526C7294869C ON comment (article_id)');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_794381c6f675f31b TO IDX_9474526CF675F31B');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4584665A');
        $this->addSql('DROP INDEX IDX_C53D045F4584665A ON image');
        $this->addSql('ALTER TABLE image ADD article_id INT NOT NULL, DROP product_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F7294869C ON image (article_id)');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_218b62124584665a TO IDX_1C21C7B27294869C');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_218b6212a76ed395 TO IDX_1C21C7B2A76ED395');
        $this->addSql('ALTER TABLE user ADD addressip VARCHAR(180) DEFAULT NULL, ADD is_activate TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495A766BA0 ON user (addressip)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historique_modif DROP FOREIGN KEY FK_D5750EB86128735E');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE historique_modif');
        $this->addSql('ALTER TABLE article DROP created_at');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_1c21c7b27294869c TO IDX_218B62124584665A');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_1c21c7b2a76ed395 TO IDX_218B6212A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('DROP INDEX IDX_9474526C7294869C ON comment');
        $this->addSql('ALTER TABLE comment DROP created_at, CHANGE article_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_794381C64584665A FOREIGN KEY (product_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_794381C64584665A ON comment (product_id)');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526cf675f31b TO IDX_794381C6F675F31B');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F7294869C');
        $this->addSql('DROP INDEX IDX_C53D045F7294869C ON image');
        $this->addSql('ALTER TABLE image ADD product_id INT DEFAULT NULL, DROP article_id');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4584665A FOREIGN KEY (product_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4584665A ON image (product_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D6495A766BA0 ON user');
        $this->addSql('ALTER TABLE user DROP addressip, DROP is_activate');
    }
}
