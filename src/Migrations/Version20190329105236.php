<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329105236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('ALTER TABLE article RENAME INDEX idx_d34a04ada76ed395 TO IDX_23A0E66A76ED395');
//        $this->addSql('ALTER TABLE article RENAME INDEX idx_d34a04adbad26311 TO IDX_23A0E66BAD26311');
//        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_218b62124584665a TO IDX_1C21C7B27294869C');
//        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_218b6212a76ed395 TO IDX_1C21C7B2A76ED395');
//        $this->addSql('ALTER TABLE comment RENAME INDEX idx_794381c6f675f31b TO IDX_9474526CF675F31B');
//        $this->addSql('ALTER TABLE comment RENAME INDEX idx_794381c64584665a TO IDX_9474526C7294869C');
//        $this->addSql('ALTER TABLE user DROP uniqid');
//        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495A766BA0 ON user (addressip)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66bad26311 TO IDX_D34A04ADBAD26311');
        $this->addSql('ALTER TABLE article RENAME INDEX idx_23a0e66a76ed395 TO IDX_D34A04ADA76ED395');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_1c21c7b2a76ed395 TO IDX_218B6212A76ED395');
        $this->addSql('ALTER TABLE article_like RENAME INDEX idx_1c21c7b27294869c TO IDX_218B62124584665A');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526c7294869c TO IDX_794381C64584665A');
        $this->addSql('ALTER TABLE comment RENAME INDEX idx_9474526cf675f31b TO IDX_794381C6F675F31B');
        $this->addSql('DROP INDEX UNIQ_8D93D6495A766BA0 ON user');
        $this->addSql('ALTER TABLE user ADD uniqid VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
