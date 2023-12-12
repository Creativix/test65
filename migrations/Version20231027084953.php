<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027084953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matches (id INT NOT NULL, tournament_id INT NOT NULL, score_id INT NOT NULL, round_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62615BA33D1A3E7 ON matches (tournament_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62615BA12EB0A51 ON matches (score_id)');
        $this->addSql('CREATE TABLE score (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE teams (id INT NOT NULL, tournament_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_96C2225833D1A3E7 ON teams (tournament_id)');
        $this->addSql('CREATE TABLE teams_matches (teams_id INT NOT NULL, matches_id INT NOT NULL, PRIMARY KEY(teams_id, matches_id))');
        $this->addSql('CREATE INDEX IDX_AEE9590ED6365F12 ON teams_matches (teams_id)');
        $this->addSql('CREATE INDEX IDX_AEE9590E4B30DD19 ON teams_matches (matches_id)');
        $this->addSql('CREATE TABLE tournament (id INT NOT NULL, name VARCHAR(255) NOT NULL, nbr_team_max INT NOT NULL, rule TEXT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA12EB0A51 FOREIGN KEY (score_id) REFERENCES score (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT FK_96C2225833D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams_matches ADD CONSTRAINT FK_AEE9590ED6365F12 FOREIGN KEY (teams_id) REFERENCES teams (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teams_matches ADD CONSTRAINT FK_AEE9590E4B30DD19 FOREIGN KEY (matches_id) REFERENCES matches (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA33D1A3E7');
        $this->addSql('ALTER TABLE matches DROP CONSTRAINT FK_62615BA12EB0A51');
        $this->addSql('ALTER TABLE teams DROP CONSTRAINT FK_96C2225833D1A3E7');
        $this->addSql('ALTER TABLE teams_matches DROP CONSTRAINT FK_AEE9590ED6365F12');
        $this->addSql('ALTER TABLE teams_matches DROP CONSTRAINT FK_AEE9590E4B30DD19');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE teams_matches');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
