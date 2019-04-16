<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415183555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE product_like');
        $this->addSql('ALTER TABLE article_picture ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article_picture ADD CONSTRAINT FK_FB090B3E7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_FB090B3E7294869C ON article_picture (article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product_like (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_218B62124584665A (product_id), INDEX IDX_218B6212A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_like ADD CONSTRAINT FK_218B62124584665A FOREIGN KEY (product_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE product_like ADD CONSTRAINT FK_218B6212A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article_picture DROP FOREIGN KEY FK_FB090B3E7294869C');
        $this->addSql('DROP INDEX IDX_FB090B3E7294869C ON article_picture');
        $this->addSql('ALTER TABLE article_picture DROP article_id');
    }
}
