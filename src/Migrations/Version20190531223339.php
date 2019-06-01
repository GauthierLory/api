<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190531223339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('DROP TABLE image');
//        $this->addSql('ALTER TABLE upload DROP FOREIGN KEY FK_17BDE61FA76ED395');
//        $this->addSql('DROP INDEX IDX_17BDE61FA76ED395 ON upload');
//        $this->addSql('ALTER TABLE upload DROP user_id, DROP created_at, DROP image_name, DROP image_original_name, DROP image_mime_type, DROP image_size, DROP image_dimensions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, image_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, image_size INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045F7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product_like (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_218B6212A76ED395 (user_id), INDEX IDX_218B62124584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE product_like ADD CONSTRAINT FK_218B62124584665A FOREIGN KEY (product_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE product_like ADD CONSTRAINT FK_218B6212A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE upload ADD user_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD image_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD image_original_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD image_mime_type VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD image_size INT DEFAULT NULL, ADD image_dimensions LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE upload ADD CONSTRAINT FK_17BDE61FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_17BDE61FA76ED395 ON upload (user_id)');
    }
}
