<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108234156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tenant_invite (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', property_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', tenant_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_E649748E549213EC (property_id), INDEX IDX_E649748E9033212A (tenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tenant_invite ADD CONSTRAINT FK_E649748E549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE tenant_invite ADD CONSTRAINT FK_E649748E9033212A FOREIGN KEY (tenant_id) REFERENCES property (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenant_invite DROP FOREIGN KEY FK_E649748E549213EC');
        $this->addSql('ALTER TABLE tenant_invite DROP FOREIGN KEY FK_E649748E9033212A');
        $this->addSql('DROP TABLE tenant_invite');
    }
}
