<?php

declare(strict_types=1);

namespace App\Infrastructure\DependencyInjection\CompilerPass;

use Nelmio\ApiDocBundle\ModelDescriber\FormModelDescriber;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RemoveFormDescriberCompilerPass implements CompilerPassInterface
{
    // @phpstan-ignore-next-line
    public function process(ContainerBuilder $container): void
    {
        $container->removeDefinition(FormModelDescriber::class);
        $container->removeDefinition('nelmio_api_doc.model_describers.form');
    }
}
