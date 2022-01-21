<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626142752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category ADD parent_id INT DEFAULT NULL, DROP parent');
        $this->addSql('ALTER TABLE tbl_category ADD CONSTRAINT FK_517FFFEC727ACA70 FOREIGN KEY (parent_id) REFERENCES tbl_category (id)');
        $this->addSql('CREATE INDEX IDX_517FFFEC727ACA70 ON tbl_category (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category DROP FOREIGN KEY FK_517FFFEC727ACA70');
        $this->addSql('DROP INDEX IDX_517FFFEC727ACA70 ON tbl_category');
        $this->addSql('ALTER TABLE tbl_category ADD parent VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP parent_id');
    }
}
