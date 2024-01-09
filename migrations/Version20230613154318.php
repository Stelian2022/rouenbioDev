<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613154318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fidelite DROP FOREIGN KEY FK_EF425B23BF396750');
        $this->addSql('ALTER TABLE fidelite ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fidelite ADD CONSTRAINT FK_EF425B23A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EF425B23A76ED395 ON fidelite (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fidelite DROP FOREIGN KEY FK_EF425B23A76ED395');
        $this->addSql('DROP INDEX UNIQ_EF425B23A76ED395 ON fidelite');
        $this->addSql('ALTER TABLE fidelite DROP user_id');
        $this->addSql('ALTER TABLE fidelite ADD CONSTRAINT FK_EF425B23BF396750 FOREIGN KEY (id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
