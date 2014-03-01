<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140301131242 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Link (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Post DROP FOREIGN KEY FK_FAB8C3B3A76ED395");
        $this->addSql("DROP INDEX IDX_FAB8C3B3A76ED395 ON Post");
        $this->addSql("ALTER TABLE Post DROP user_id, CHANGE content content VARCHAR(25000) NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE Link");
        $this->addSql("ALTER TABLE Post ADD user_id INT DEFAULT NULL, CHANGE content content LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE Post ADD CONSTRAINT FK_FAB8C3B3A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)");
        $this->addSql("CREATE INDEX IDX_FAB8C3B3A76ED395 ON Post (user_id)");
    }
}
