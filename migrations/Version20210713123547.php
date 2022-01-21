<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210713123547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category_relation DROP FOREIGN KEY FK_6BF20DA0727ACA70');
        $this->addSql('ALTER TABLE tbl_category_relation DROP FOREIGN KEY FK_6BF20DA0DD62C21B');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0727ACA70 FOREIGN KEY (parent_id) REFERENCES tbl_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0DD62C21B FOREIGN KEY (child_id) REFERENCES tbl_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category_relation DROP FOREIGN KEY FK_6BF20DA0727ACA70');
        $this->addSql('ALTER TABLE tbl_category_relation DROP FOREIGN KEY FK_6BF20DA0DD62C21B');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0727ACA70 FOREIGN KEY (parent_id) REFERENCES tbl_category (id)');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0DD62C21B FOREIGN KEY (child_id) REFERENCES tbl_category (id)');
    }
}
