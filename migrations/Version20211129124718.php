<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129124718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category CHANGE `order` position INT NOT NULL');
        $this->addSql('ALTER TABLE tbl_user CHANGE id id INT UNSIGNED NOT NULL AUTO_INCREMENT, CHANGE activation_token activation_token VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_category CHANGE position `order` INT NOT NULL');
        $this->addSql('ALTER TABLE tbl_user CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE activation_token activation_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
