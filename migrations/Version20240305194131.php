<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305194131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `image` (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(128) DEFAULT NULL, context VARCHAR(128) NOT NULL, path VARCHAR(255) NOT NULL, entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', suspended_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE INDEX idx_context_entity_id ON `image` (context, entity_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX idx_context_entity_id ON `image`');
        $this->addSql('DROP TABLE image');
    }
}
