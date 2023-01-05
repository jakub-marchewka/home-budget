<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105162101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bill_user (bill_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_7E8CBEE31A8C12F5 (bill_id), INDEX IDX_7E8CBEE3A76ED395 (user_id), PRIMARY KEY(bill_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bill_user ADD CONSTRAINT FK_7E8CBEE31A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill_user ADD CONSTRAINT FK_7E8CBEE3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bill DROP paid');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bill_user DROP FOREIGN KEY FK_7E8CBEE31A8C12F5');
        $this->addSql('ALTER TABLE bill_user DROP FOREIGN KEY FK_7E8CBEE3A76ED395');
        $this->addSql('DROP TABLE bill_user');
        $this->addSql('ALTER TABLE bill ADD paid TINYINT(1) NOT NULL');
    }
}
