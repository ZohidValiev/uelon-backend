<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719161423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('DROP INDEX category_language ON tbl_category_translation');
        $this->addSql('ALTER TABLE tbl_category_translation ADD locale VARCHAR(2) NOT NULL, DROP language_id');
        $this->addSql('CREATE UNIQUE INDEX category_locale ON tbl_category_translation (category_id, locale)');
        $this->addSql('ALTER TABLE tbl_language ADD title VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX category_locale ON tbl_category_translation');
        $this->addSql('ALTER TABLE tbl_category_translation ADD language_id INT NOT NULL, DROP locale');
        $this->addSql('CREATE UNIQUE INDEX category_language ON tbl_category_translation (category_id, language_id)');
        $this->addSql('ALTER TABLE tbl_language DROP title, CHANGE code code VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
