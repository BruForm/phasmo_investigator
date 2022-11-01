<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221101180526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE param_level_map_size (id INT AUTO_INCREMENT NOT NULL, level_id INT DEFAULT NULL, map_size_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, value INT NOT NULL, duration TIME NOT NULL, INDEX IDX_96660ECE5FB14BA7 (level_id), INDEX IDX_96660ECE66A6507B (map_size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE param_level_map_size ADD CONSTRAINT FK_96660ECE5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE param_level_map_size ADD CONSTRAINT FK_96660ECE66A6507B FOREIGN KEY (map_size_id) REFERENCES map_size (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE param_level_map_size DROP FOREIGN KEY FK_96660ECE5FB14BA7');
        $this->addSql('ALTER TABLE param_level_map_size DROP FOREIGN KEY FK_96660ECE66A6507B');
        $this->addSql('DROP TABLE param_level_map_size');
    }
}
