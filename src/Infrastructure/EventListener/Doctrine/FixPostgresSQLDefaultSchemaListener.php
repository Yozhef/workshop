<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Exception as DbalException;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\When;

/**
 * Fix for https://github.com/doctrine/migrations/issues/441
 *         https://github.com/doctrine/dbal/issues/1110
 */

#[When('dev')]
#[AsDoctrineListener(event: ToolEvents::postGenerateSchema)]
#[AutoconfigureTag('doctrine.event_listener', ['event' => ToolEvents::postGenerateSchema])]
final class FixPostgresSQLDefaultSchemaListener
{
    /**
     * @throws DbalException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        if (!$schemaManager instanceof PostgreSQLSchemaManager) {
            return;
        }

        $schema = $args->getSchema();

        foreach ($schemaManager->listSchemaNames() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }
}
