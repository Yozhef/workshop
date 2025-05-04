<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private $loader,
        private readonly string $rootDir,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->loader->load([
            $this->rootDir . '/tests/DataFixtures/ORM/Base.yml',
        ]);
    }
}
