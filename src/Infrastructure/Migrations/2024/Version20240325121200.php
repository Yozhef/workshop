<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240325121200 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN default_entity.id IS \'\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN default_entity.id IS \'(DC2Type:uuid)\'');
    }
}
