<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320110341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing_address DROP first_name, DROP last_name');
        $this->addSql('ALTER TABLE shipping_address ADD first_name_shipping_address VARCHAR(255) DEFAULT NULL, ADD last_name_shipping_address VARCHAR(255) DEFAULT NULL, ADD phone_shipping_address VARCHAR(255) DEFAULT NULL, DROP first_name, DROP last_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE billing_address ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE shipping_address ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, DROP first_name_shipping_address, DROP last_name_shipping_address, DROP phone_shipping_address');
    }
}
