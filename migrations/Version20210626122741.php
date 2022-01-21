<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626122741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_category_relation (parent_id INT NOT NULL, child_id INT NOT NULL, INDEX IDX_6BF20DA0727ACA70 (parent_id), INDEX child_id (child_id), PRIMARY KEY(parent_id, child_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0727ACA70 FOREIGN KEY (parent_id) REFERENCES tbl_category (id)');
        $this->addSql('ALTER TABLE tbl_category_relation ADD CONSTRAINT FK_6BF20DA0DD62C21B FOREIGN KEY (child_id) REFERENCES tbl_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tbl_category_relation');
    }
}
