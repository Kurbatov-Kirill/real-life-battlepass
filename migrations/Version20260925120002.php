<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260925120002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE battlepass (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, created_at DATETIME NOT NULL, player_1_id INT NOT NULL, player_2_id INT NOT NULL, INDEX IDX_8C6D7EAA52C90CC9 (player_1_id), INDEX IDX_8C6D7EAA407CA327 (player_2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(32) NOT NULL, title VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, url VARCHAR(255) DEFAULT NULL, is_read TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, target_id INT NOT NULL, INDEX IDX_BF5476CA158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(64) NOT NULL, avatar_url VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, helpers_url VARCHAR(255) DEFAULT NULL, reward VARCHAR(255) DEFAULT NULL, is_reward_hidden TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, deadline_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, approved_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, battlepass_id INT NOT NULL, creator_id INT NOT NULL, target_id INT NOT NULL, INDEX IDX_4317F81730115497 (battlepass_id), INDEX IDX_4317F81761220EA6 (creator_id), INDEX IDX_4317F817158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE quest_history (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(32) NOT NULL, message LONGTEXT DEFAULT NULL, proof_url VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, quest_id INT NOT NULL, actor_id INT DEFAULT NULL, INDEX IDX_739DCD00209E9EF4 (quest_id), INDEX IDX_739DCD0010DAF24A (actor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE battlepass ADD CONSTRAINT FK_8C6D7EAA52C90CC9 FOREIGN KEY (player_1_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE battlepass ADD CONSTRAINT FK_8C6D7EAA407CA327 FOREIGN KEY (player_2_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA158E0B66 FOREIGN KEY (target_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F81730115497 FOREIGN KEY (battlepass_id) REFERENCES battlepass (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F81761220EA6 FOREIGN KEY (creator_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817158E0B66 FOREIGN KEY (target_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE quest_history ADD CONSTRAINT FK_739DCD00209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_history ADD CONSTRAINT FK_739DCD0010DAF24A FOREIGN KEY (actor_id) REFERENCES profile (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE battlepass DROP FOREIGN KEY FK_8C6D7EAA52C90CC9');
        $this->addSql('ALTER TABLE battlepass DROP FOREIGN KEY FK_8C6D7EAA407CA327');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA158E0B66');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F81730115497');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F81761220EA6');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817158E0B66');
        $this->addSql('ALTER TABLE quest_history DROP FOREIGN KEY FK_739DCD00209E9EF4');
        $this->addSql('ALTER TABLE quest_history DROP FOREIGN KEY FK_739DCD0010DAF24A');
        $this->addSql('DROP TABLE battlepass');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE quest');
        $this->addSql('DROP TABLE quest_history');
    }
}
