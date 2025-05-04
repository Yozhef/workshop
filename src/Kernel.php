<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\DependencyInjection\CompilerPass\RemoveFormDescriberCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RemoveFormDescriberCompilerPass());
    }

    public function shutdown(): void
    {
        if ($this->getEnvironment() === 'test') {
            $this->resetBundles();
        } else {
            parent::shutdown();
        }
    }

    private function resetBundles(): void
    {
        $container = $this->getContainer();

        if ($container->initialized('kernel') === false) {
            return;
        }

        $this->resetDoctrineBundle($container);
    }

    private function resetDoctrineBundle(ContainerInterface $container): void
    {
        foreach ($container->getParameter('doctrine.entity_managers') as $entityManagerId) {
            if ($container->initialized($entityManagerId)) {
                $em = $container->get($entityManagerId);
                $em->clear();

                $connection = $em->getConnection();

                if ($connection->isConnected()) {
                    $connection->close();
                }
            }
        }
    }
}
