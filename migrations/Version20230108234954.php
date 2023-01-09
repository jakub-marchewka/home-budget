<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108234954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenant_invite ADD tenant_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tenant_invite ADD CONSTRAINT FK_E649748E9033212A FOREIGN KEY (tenant_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_E649748E9033212A ON tenant_invite (tenant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tenant_invite DROP FOREIGN KEY FK_E649748E9033212A');
        $this->addSql('DROP INDEX IDX_E649748E9033212A ON tenant_invite');
        $this->addSql('ALTER TABLE tenant_invite DROP tenant_id');
    }
}
