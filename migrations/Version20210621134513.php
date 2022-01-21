<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621134513 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category_translation CHANGE category_id category_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX category_language ON tbl_category_translation (category_id, language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX category_language ON tbl_category_translation');
        $this->addSql('ALTER TABLE tbl_category_translation CHANGE category_id category_id INT DEFAULT NULL');
    }
}
