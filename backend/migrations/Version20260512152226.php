<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260512152226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercises (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, muscle_group_id INT NOT NULL, INDEX IDX_FA1499144004D0 (muscle_group_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exercises_muscles (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) NOT NULL, exercise_id INT NOT NULL, muscle_id INT NOT NULL, INDEX IDX_3DA911D9E934951A (exercise_id), INDEX IDX_3DA911D9354FDBB4 (muscle_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE exercises_variants (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, exercise_id INT NOT NULL, INDEX IDX_66EEF335E934951A (exercise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE muscle_groups (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE muscles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, muscle_group_id INT NOT NULL, INDEX IDX_2B4821FB44004D0 (muscle_group_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE training_goal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE training_level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE training_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE work_plan (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, days_per_week INT NOT NULL, duration_weeks INT DEFAULT NULL, is_active TINYINT NOT NULL, training_goal_id INT NOT NULL, training_level_id INT NOT NULL, work_split_id INT NOT NULL, INDEX IDX_2499EA45BB438AF0 (training_goal_id), INDEX IDX_2499EA45B8D45830 (training_level_id), INDEX IDX_2499EA45E869E299 (work_split_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE work_split (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE workout (id INT AUTO_INCREMENT NOT NULL, sets INT NOT NULL, reps INT NOT NULL, weight DOUBLE PRECISION NOT NULL, comments LONGTEXT DEFAULT NULL, date DATETIME NOT NULL, user_id INT DEFAULT NULL, exercise_id INT DEFAULT NULL, INDEX IDX_649FFB72A76ED395 (user_id), INDEX IDX_649FFB72E934951A (exercise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE exercises ADD CONSTRAINT FK_FA1499144004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_groups (id)');
        $this->addSql('ALTER TABLE exercises_muscles ADD CONSTRAINT FK_3DA911D9E934951A FOREIGN KEY (exercise_id) REFERENCES exercises (id)');
        $this->addSql('ALTER TABLE exercises_muscles ADD CONSTRAINT FK_3DA911D9354FDBB4 FOREIGN KEY (muscle_id) REFERENCES muscles (id)');
        $this->addSql('ALTER TABLE exercises_variants ADD CONSTRAINT FK_66EEF335E934951A FOREIGN KEY (exercise_id) REFERENCES exercises (id)');
        $this->addSql('ALTER TABLE muscles ADD CONSTRAINT FK_2B4821FB44004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_groups (id)');
        $this->addSql('ALTER TABLE work_plan ADD CONSTRAINT FK_2499EA45BB438AF0 FOREIGN KEY (training_goal_id) REFERENCES training_goal (id)');
        $this->addSql('ALTER TABLE work_plan ADD CONSTRAINT FK_2499EA45B8D45830 FOREIGN KEY (training_level_id) REFERENCES training_level (id)');
        $this->addSql('ALTER TABLE work_plan ADD CONSTRAINT FK_2499EA45E869E299 FOREIGN KEY (work_split_id) REFERENCES work_split (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE workout ADD CONSTRAINT FK_649FFB72E934951A FOREIGN KEY (exercise_id) REFERENCES exercises (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercises DROP FOREIGN KEY FK_FA1499144004D0');
        $this->addSql('ALTER TABLE exercises_muscles DROP FOREIGN KEY FK_3DA911D9E934951A');
        $this->addSql('ALTER TABLE exercises_muscles DROP FOREIGN KEY FK_3DA911D9354FDBB4');
        $this->addSql('ALTER TABLE exercises_variants DROP FOREIGN KEY FK_66EEF335E934951A');
        $this->addSql('ALTER TABLE muscles DROP FOREIGN KEY FK_2B4821FB44004D0');
        $this->addSql('ALTER TABLE work_plan DROP FOREIGN KEY FK_2499EA45BB438AF0');
        $this->addSql('ALTER TABLE work_plan DROP FOREIGN KEY FK_2499EA45B8D45830');
        $this->addSql('ALTER TABLE work_plan DROP FOREIGN KEY FK_2499EA45E869E299');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72A76ED395');
        $this->addSql('ALTER TABLE workout DROP FOREIGN KEY FK_649FFB72E934951A');
        $this->addSql('DROP TABLE exercises');
        $this->addSql('DROP TABLE exercises_muscles');
        $this->addSql('DROP TABLE exercises_variants');
        $this->addSql('DROP TABLE muscle_groups');
        $this->addSql('DROP TABLE muscles');
        $this->addSql('DROP TABLE training_goal');
        $this->addSql('DROP TABLE training_level');
        $this->addSql('DROP TABLE training_method');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_plan');
        $this->addSql('DROP TABLE work_split');
        $this->addSql('DROP TABLE workout');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
