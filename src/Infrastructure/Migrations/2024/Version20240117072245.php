<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240117072245 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE default_entity (
            id UUID NOT NULL,
            name VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id))
        ');
        $this->addSql('COMMENT ON COLUMN default_entity.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE default_entity');
    }
}
