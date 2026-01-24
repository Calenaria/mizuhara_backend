<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260124113031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CONFIG_KEY ON app_configuration (key)');
        $this->addSql('ALTER TABLE shopping_list_collection ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE shopping_list_collection DROP owner');
        $this->addSql('ALTER TABLE shopping_list_collection ADD CONSTRAINT FK_8D328DE77E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_8D328DE77E3C61F9 ON shopping_list_collection (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_CONFIG_KEY');
        $this->addSql('ALTER TABLE shopping_list_collection DROP CONSTRAINT FK_8D328DE77E3C61F9');
        $this->addSql('DROP INDEX IDX_8D328DE77E3C61F9');
        $this->addSql('ALTER TABLE shopping_list_collection ADD owner VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE shopping_list_collection DROP owner_id');
    }
}
