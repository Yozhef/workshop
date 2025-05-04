<?php

declare(strict_types=1);

namespace App\Infrastructure\DependencyInjection\Factory;

use App\Tests\DataFixtures\Faker\FakerProviderInterface;
use Nelmio\Alice\Loader\NativeLoader;

class AliceNativeLoaderFactory
{
    /** @param FakerProviderInterface[] $fakerProviders */
    public static function create(iterable $fakerProviders): NativeLoader
    {
        $loader = new NativeLoader();
        $faker = $loader->getFakerGenerator();

        foreach ($fakerProviders as $provider) {
            $faker->addProvider($provider);
        }

        return $loader;
    }
}
