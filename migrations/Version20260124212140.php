<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260124212140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_information ADD product_name VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD generic_name TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD brand_owner VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD quantity VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD product_quantity VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD packaging TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD categories TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD categories_tags TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD main_category VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD food_groups TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD pnns_groups1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD pnns_groups2 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD ingredients_text TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD ingredients_tags TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD ingredients_analysis_tags TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD labels TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD labels_tags TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD allergens TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD energy_kcal100g NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD proteins100g NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD fat100g NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD carbohydrates100g NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD fiber100g NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD vitamin_b12100g NUMERIC(10, 6) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD iron100g NUMERIC(10, 6) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD calcium100g NUMERIC(10, 6) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD stores TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD purchase_places TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD countries VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD environmental_score_score INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD environmental_score_grade VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ADD image_url TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_information ALTER brand_id DROP NOT NULL');
        $this->addSql('ALTER TABLE product_information RENAME COLUMN name TO code');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8556869C77153098 ON product_information (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8556869C77153098');
        $this->addSql('ALTER TABLE product_information DROP product_name');
        $this->addSql('ALTER TABLE product_information DROP generic_name');
        $this->addSql('ALTER TABLE product_information DROP brand_owner');
        $this->addSql('ALTER TABLE product_information DROP quantity');
        $this->addSql('ALTER TABLE product_information DROP product_quantity');
        $this->addSql('ALTER TABLE product_information DROP packaging');
        $this->addSql('ALTER TABLE product_information DROP categories');
        $this->addSql('ALTER TABLE product_information DROP categories_tags');
        $this->addSql('ALTER TABLE product_information DROP main_category');
        $this->addSql('ALTER TABLE product_information DROP food_groups');
        $this->addSql('ALTER TABLE product_information DROP pnns_groups1');
        $this->addSql('ALTER TABLE product_information DROP pnns_groups2');
        $this->addSql('ALTER TABLE product_information DROP ingredients_text');
        $this->addSql('ALTER TABLE product_information DROP ingredients_tags');
        $this->addSql('ALTER TABLE product_information DROP ingredients_analysis_tags');
        $this->addSql('ALTER TABLE product_information DROP labels');
        $this->addSql('ALTER TABLE product_information DROP labels_tags');
        $this->addSql('ALTER TABLE product_information DROP allergens');
        $this->addSql('ALTER TABLE product_information DROP energy_kcal100g');
        $this->addSql('ALTER TABLE product_information DROP proteins100g');
        $this->addSql('ALTER TABLE product_information DROP fat100g');
        $this->addSql('ALTER TABLE product_information DROP carbohydrates100g');
        $this->addSql('ALTER TABLE product_information DROP fiber100g');
        $this->addSql('ALTER TABLE product_information DROP vitamin_b12100g');
        $this->addSql('ALTER TABLE product_information DROP iron100g');
        $this->addSql('ALTER TABLE product_information DROP calcium100g');
        $this->addSql('ALTER TABLE product_information DROP stores');
        $this->addSql('ALTER TABLE product_information DROP purchase_places');
        $this->addSql('ALTER TABLE product_information DROP countries');
        $this->addSql('ALTER TABLE product_information DROP environmental_score_score');
        $this->addSql('ALTER TABLE product_information DROP environmental_score_grade');
        $this->addSql('ALTER TABLE product_information DROP image_url');
        $this->addSql('ALTER TABLE product_information ALTER brand_id SET NOT NULL');
        $this->addSql('ALTER TABLE product_information RENAME COLUMN code TO name');
    }
}
