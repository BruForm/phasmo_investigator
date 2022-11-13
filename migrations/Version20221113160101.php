<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113160101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, map_id INT DEFAULT NULL, level_id INT DEFAULT NULL, entity_id INT DEFAULT NULL, chosen_entity_id INT DEFAULT NULL, duration TIME NOT NULL, INDEX IDX_232B318C99E6F5DF (player_id), INDEX IDX_232B318C53C55F64 (map_id), INDEX IDX_232B318C5FB14BA7 (level_id), INDEX IDX_232B318C81257D5D (entity_id), INDEX IDX_232B318C3192C2C1 (chosen_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C81257D5D FOREIGN KEY (entity_id) REFERENCES entity (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3192C2C1 FOREIGN KEY (chosen_entity_id) REFERENCES entity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C99E6F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C53C55F64');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5FB14BA7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C81257D5D');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3192C2C1');
        $this->addSql('DROP TABLE game');
    }
}
