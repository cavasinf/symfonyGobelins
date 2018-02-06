<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180206122006 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abstract VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, releaseDate DATETIME NOT NULL, mainPicture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_category (show_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_3F28F82ED0C1FC64 (show_id), INDEX IDX_3F28F82E12469DE2 (category_id), PRIMARY KEY(show_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE show_category ADD CONSTRAINT FK_3F28F82ED0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_category ADD CONSTRAINT FK_3F28F82E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE show_category DROP FOREIGN KEY FK_3F28F82E12469DE2');
        $this->addSql('ALTER TABLE show_category DROP FOREIGN KEY FK_3F28F82ED0C1FC64');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE show_category');
    }
}
