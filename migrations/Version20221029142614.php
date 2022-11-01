<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029142614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characteristic (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_522FA950C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characteristic_entity (characteristic_id INT NOT NULL, entity_id INT NOT NULL, INDEX IDX_C8487586DEE9D12B (characteristic_id), INDEX IDX_C848758681257D5D (entity_id), PRIMARY KEY(characteristic_id, entity_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cursed_object (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, utilisation LONGTEXT NOT NULL, utility LONGTEXT NOT NULL, INDEX IDX_35332AE4C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, special_move LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_evidence (entity_id INT NOT NULL, evidence_id INT NOT NULL, INDEX IDX_AE95EB5081257D5D (entity_id), INDEX IDX_AE95EB50B528FC11 (evidence_id), PRIMARY KEY(entity_id, evidence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evidence (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, map_id INT NOT NULL, level_id INT NOT NULL, entity_id INT NOT NULL, chosen_entity_id INT NOT NULL, duration TIME NOT NULL, UNIQUE INDEX UNIQ_232B318C99E6F5DF (player_id), UNIQUE INDEX UNIQ_232B318C53C55F64 (map_id), UNIQUE INDEX UNIQ_232B318C5FB14BA7 (level_id), UNIQUE INDEX UNIQ_232B318C81257D5D (entity_id), UNIQUE INDEX UNIQ_232B318C3192C2C1 (chosen_entity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, free_run_time TIME NOT NULL, hunt_grace_time TIME NOT NULL, sanity_by_pill INT NOT NULL, insurance_payment INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, map_size_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, nb_floor INT NOT NULL, nb_room INT NOT NULL, INDEX IDX_93ADAABB66A6507B (map_size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map_size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optional_goal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, nb_investig INT NOT NULL, nb_success INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characteristic ADD CONSTRAINT FK_522FA950C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE characteristic_entity ADD CONSTRAINT FK_C8487586DEE9D12B FOREIGN KEY (characteristic_id) REFERENCES characteristic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characteristic_entity ADD CONSTRAINT FK_C848758681257D5D FOREIGN KEY (entity_id) REFERENCES entity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cursed_object ADD CONSTRAINT FK_35332AE4C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE entity_evidence ADD CONSTRAINT FK_AE95EB5081257D5D FOREIGN KEY (entity_id) REFERENCES entity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entity_evidence ADD CONSTRAINT FK_AE95EB50B528FC11 FOREIGN KEY (evidence_id) REFERENCES evidence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C53C55F64 FOREIGN KEY (map_id) REFERENCES map (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C81257D5D FOREIGN KEY (entity_id) REFERENCES entity (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3192C2C1 FOREIGN KEY (chosen_entity_id) REFERENCES entity (id)');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABB66A6507B FOREIGN KEY (map_size_id) REFERENCES map_size (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characteristic DROP FOREIGN KEY FK_522FA950C54C8C93');
        $this->addSql('ALTER TABLE characteristic_entity DROP FOREIGN KEY FK_C8487586DEE9D12B');
        $this->addSql('ALTER TABLE characteristic_entity DROP FOREIGN KEY FK_C848758681257D5D');
        $this->addSql('ALTER TABLE cursed_object DROP FOREIGN KEY FK_35332AE4C54C8C93');
        $this->addSql('ALTER TABLE entity_evidence DROP FOREIGN KEY FK_AE95EB5081257D5D');
        $this->addSql('ALTER TABLE entity_evidence DROP FOREIGN KEY FK_AE95EB50B528FC11');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C99E6F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C53C55F64');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5FB14BA7');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C81257D5D');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3192C2C1');
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABB66A6507B');
        $this->addSql('DROP TABLE characteristic');
        $this->addSql('DROP TABLE characteristic_entity');
        $this->addSql('DROP TABLE cursed_object');
        $this->addSql('DROP TABLE entity');
        $this->addSql('DROP TABLE entity_evidence');
        $this->addSql('DROP TABLE evidence');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE map_size');
        $this->addSql('DROP TABLE optional_goal');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE skin');
        $this->addSql('DROP TABLE type');
    }
}
