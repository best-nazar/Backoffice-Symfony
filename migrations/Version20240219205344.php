<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219205344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(128) NOT NULL, last_name VARCHAR(128) NOT NULL, username VARCHAR(128) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', suspended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active SMALLINT NOT NULL, is_verified TINYINT NOT NULL, roles JSON, password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `profile` (id INT AUTO_INCREMENT NOT NULL, user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', avatar_path VARCHAR(255) DEFAULT NULL, last_visited TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_6602230FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `profile` ADD CONSTRAINT FK_6602230FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        // Add index for the "username" column
        $this->addSql('CREATE INDEX idx_username ON user (username)');
        // Add index for the "email" column
        $this->addSql('CREATE INDEX idx_email ON user (email)');
        // Add composite index for "username" and "isActive" columns
        $this->addSql('CREATE INDEX idx_username_is_active ON user (username, is_active)');
    }

    public function down(Schema $schema): void
    {
         // Reverse the changes if needed
        $this->addSql('DROP INDEX idx_username ON user');
        $this->addSql('DROP INDEX idx_email ON user');
        $this->addSql('DROP INDEX idx_username_is_active ON user');

        $this->addSql('ALTER TABLE `profile` DROP FOREIGN KEY FK_6602230FA76ED395');
        $this->addSql('DROP TABLE `profile`');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
