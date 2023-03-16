<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216130854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB932F68B530');
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB939D86650F');
        $this->addSql('DROP INDEX IDX_BD97DB939D86650F ON group_request');
        $this->addSql('DROP INDEX IDX_BD97DB932F68B530 ON group_request');
        $this->addSql('ALTER TABLE group_request ADD user_id INT NOT NULL, ADD group_id INT NOT NULL, DROP user_id_id, DROP group_id_id');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB93FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_BD97DB93A76ED395 ON group_request (user_id)');
        $this->addSql('CREATE INDEX IDX_BD97DB93FE54D947 ON group_request (group_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F75C0816C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F8FDDAB70');
        $this->addSql('DROP INDEX IDX_B6BD307F75C0816C ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F8FDDAB70 ON message');
        $this->addSql('ALTER TABLE message CHANGE thread_id_id thread_id INT DEFAULT NULL, CHANGE owner_id_id owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE2904019 ON message (thread_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C832F68B530');
        $this->addSql('DROP INDEX IDX_31204C832F68B530 ON thread');
        $this->addSql('ALTER TABLE thread CHANGE group_id_id group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C83FE54D947 FOREIGN KEY (group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_31204C83FE54D947 ON thread (group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB93A76ED395');
        $this->addSql('ALTER TABLE group_request DROP FOREIGN KEY FK_BD97DB93FE54D947');
        $this->addSql('DROP INDEX IDX_BD97DB93A76ED395 ON group_request');
        $this->addSql('DROP INDEX IDX_BD97DB93FE54D947 ON group_request');
        $this->addSql('ALTER TABLE group_request ADD user_id_id INT NOT NULL, ADD group_id_id INT NOT NULL, DROP user_id, DROP group_id');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB932F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE group_request ADD CONSTRAINT FK_BD97DB939D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BD97DB939D86650F ON group_request (user_id_id)');
        $this->addSql('CREATE INDEX IDX_BD97DB932F68B530 ON group_request (group_id_id)');
        $this->addSql('ALTER TABLE thread DROP FOREIGN KEY FK_31204C83FE54D947');
        $this->addSql('DROP INDEX IDX_31204C83FE54D947 ON thread');
        $this->addSql('ALTER TABLE thread CHANGE group_id group_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C832F68B530 FOREIGN KEY (group_id_id) REFERENCES `group` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_31204C832F68B530 ON thread (group_id_id)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE2904019');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F7E3C61F9');
        $this->addSql('DROP INDEX IDX_B6BD307FE2904019 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F7E3C61F9 ON message');
        $this->addSql('ALTER TABLE message CHANGE thread_id thread_id_id INT DEFAULT NULL, CHANGE owner_id owner_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F75C0816C FOREIGN KEY (thread_id_id) REFERENCES thread (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F8FDDAB70 FOREIGN KEY (owner_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6BD307F75C0816C ON message (thread_id_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F8FDDAB70 ON message (owner_id_id)');
    }
}
