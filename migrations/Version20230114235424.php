<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230114235424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EA46B835');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EA46B835 FOREIGN KEY (current_property_id) REFERENCES property (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649EA46B835');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649EA46B835 FOREIGN KEY (current_property_id) REFERENCES property (id)');
    }
}
