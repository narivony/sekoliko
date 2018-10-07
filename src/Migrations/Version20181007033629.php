<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181007033629 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sekoliko_horaire (id INT AUTO_INCREMENT NOT NULL, hr_date_debut_saison DATETIME DEFAULT NULL, hr_date_fin_saison DATETIME DEFAULT NULL, hr_debut TIME DEFAULT NULL, hr_fin TIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sekoliko_jour_ferie (id INT AUTO_INCREMENT NOT NULL, jr_fer_nom VARCHAR(45) DEFAULT NULL, jr_fer_date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sekoliko_role (id INT AUTO_INCREMENT NOT NULL, rl_name VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sekoliko_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', usr_firstname VARCHAR(255) DEFAULT NULL, usr_lastname VARCHAR(255) DEFAULT NULL, usr_address VARCHAR(255) DEFAULT NULL, usr_date_create DATETIME DEFAULT NULL, usr_date_update DATETIME DEFAULT NULL, usr_phone VARCHAR(45) DEFAULT NULL, usr_photo VARCHAR(255) DEFAULT NULL, usr_raison_sociale VARCHAR(255) DEFAULT NULL, usr_color VARCHAR(10) DEFAULT \'#ff00ff\' NOT NULL, UNIQUE INDEX username_canonical_UNIQUE (username_canonical), UNIQUE INDEX email_canonical_UNIQUE (email_canonical), UNIQUE INDEX confirmation_token_UNIQUE (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sekoliko_horaire');
        $this->addSql('DROP TABLE sekoliko_jour_ferie');
        $this->addSql('DROP TABLE sekoliko_role');
        $this->addSql('DROP TABLE sekoliko_user');
    }
}
