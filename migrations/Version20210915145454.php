<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210915145454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE smart_phone (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(6, 2) NOT NULL, release_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_smart_phone (user_id INT NOT NULL, smart_phone_id INT NOT NULL, INDEX IDX_43BAEE9BA76ED395 (user_id), INDEX IDX_43BAEE9B17CBC9CB (smart_phone_id), PRIMARY KEY(user_id, smart_phone_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_client (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, INDEX IDX_A2161F68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_smart_phone ADD CONSTRAINT FK_43BAEE9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_smart_phone ADD CONSTRAINT FK_43BAEE9B17CBC9CB FOREIGN KEY (smart_phone_id) REFERENCES smart_phone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_client ADD CONSTRAINT FK_A2161F68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_smart_phone DROP FOREIGN KEY FK_43BAEE9B17CBC9CB');
        $this->addSql('ALTER TABLE user_smart_phone DROP FOREIGN KEY FK_43BAEE9BA76ED395');
        $this->addSql('ALTER TABLE user_client DROP FOREIGN KEY FK_A2161F68A76ED395');
        $this->addSql('DROP TABLE smart_phone');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_smart_phone');
        $this->addSql('DROP TABLE user_client');
    }
}
