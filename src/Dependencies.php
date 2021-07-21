<?php

namespace Sfneal\Dependencies;

use Sfneal\Dependencies\Services\DependenciesRepository;

class Dependencies
{
    /**
     * Retrieve dependencies from the composer.json file & optionally include 'dev' dependencies.
     *
     * @param bool $devComposerDependencies
     * @return DependenciesRepository
     */
    public static function fromComposer(bool $devComposerDependencies = false): DependenciesRepository
    {
        return (new DependenciesRepository())->fromComposer($devComposerDependencies);
    }

    /**
     * Retrieve dependencies from the config file.
     *
     * @return DependenciesRepository
     */
    public static function fromConfig(): DependenciesRepository
    {
        return (new DependenciesRepository())->fromConfig();
    }

    /**
     * Retrieve dependencies from an array.
     *
     * @param array $dependencies
     * @return DependenciesRepository
     */
    public static function fromArray(array $dependencies): DependenciesRepository
    {
        return (new DependenciesRepository())->fromArray($dependencies);
    }
}
