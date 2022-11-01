<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031160924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, utilisation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_evidence (equipment_id INT NOT NULL, evidence_id INT NOT NULL, INDEX IDX_3CA2D336517FE9FE (equipment_id), INDEX IDX_3CA2D336B528FC11 (evidence_id), PRIMARY KEY(equipment_id, evidence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE optional_goal_equipment (optional_goal_id INT NOT NULL, equipment_id INT NOT NULL, INDEX IDX_376553C28CE8E0FF (optional_goal_id), INDEX IDX_376553C2517FE9FE (equipment_id), PRIMARY KEY(optional_goal_id, equipment_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment_evidence ADD CONSTRAINT FK_3CA2D336517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment_evidence ADD CONSTRAINT FK_3CA2D336B528FC11 FOREIGN KEY (evidence_id) REFERENCES evidence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optional_goal_equipment ADD CONSTRAINT FK_376553C28CE8E0FF FOREIGN KEY (optional_goal_id) REFERENCES optional_goal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optional_goal_equipment ADD CONSTRAINT FK_376553C2517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE optional_goal CHANGE description description VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment_evidence DROP FOREIGN KEY FK_3CA2D336517FE9FE');
        $this->addSql('ALTER TABLE equipment_evidence DROP FOREIGN KEY FK_3CA2D336B528FC11');
        $this->addSql('ALTER TABLE optional_goal_equipment DROP FOREIGN KEY FK_376553C28CE8E0FF');
        $this->addSql('ALTER TABLE optional_goal_equipment DROP FOREIGN KEY FK_376553C2517FE9FE');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE equipment_evidence');
        $this->addSql('DROP TABLE optional_goal_equipment');
        $this->addSql('ALTER TABLE optional_goal CHANGE description description LONGTEXT NOT NULL');
    }
}
