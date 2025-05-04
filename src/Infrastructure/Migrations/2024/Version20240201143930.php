<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240201143930 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE default_entity ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE default_entity ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');

        $this->addSql('UPDATE default_entity SET created_at = NOW()');
        $this->addSql('UPDATE default_entity SET updated_at = NOW()');

        $this->addSql('ALTER TABLE default_entity ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE default_entity ALTER updated_at SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE default_entity DROP created_at');
        $this->addSql('ALTER TABLE default_entity DROP updated_at');
    }
}
