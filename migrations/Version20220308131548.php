<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220308131548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create account table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, company VARCHAR(255) DEFAULT NULL, countries JSON NOT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translation ADD account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE translation ADD CONSTRAINT FK_B469456F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('CREATE INDEX IDX_B469456F9B6B5FBA ON translation (account_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE translation DROP FOREIGN KEY FK_B469456F9B6B5FBA');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP INDEX IDX_B469456F9B6B5FBA ON translation');
        $this->addSql('ALTER TABLE translation DROP account_id, CHANGE uuid uuid VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code code VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE value value LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(3) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
