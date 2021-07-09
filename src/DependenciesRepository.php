<?php

namespace Sfneal\Dependencies;

use Illuminate\Support\Collection;
use Sfneal\Dependencies\Utils\DependenciesService;
use Sfneal\Helpers\Strings\StringHelpers;

class DependenciesRepository
{
    // todo: add caching support?

    /**
     * @var bool Use composer dependencies instead of list of dependencies from the config
     */
    private $allComposerDependencies;

    /**
     * DependenciesRepository constructor.
     *
     * @param bool $allComposerDependencies
     */
    public function __construct(bool $allComposerDependencies = false)
    {
        $this->allComposerDependencies = $allComposerDependencies;
    }

    /**
     * Retrieve a Collection of Dependencies with GitHub, Packagist verison & Travis CI build status URLs.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->getDependencies()->map(function (string $type, string $dependency) {
            return new DependenciesService($dependency, $type);
        });
    }

    /**
     * Retrieve a list of dependencies from the config file or by reading the composer.json 'requires' section.
     *
     * @return Collection
     */
    private function getDependencies(): Collection
    {
        if ($this->allComposerDependencies) {
            return self::getComposerRequirements();
        }

        return self::getConfigDependencies() ?? self::getComposerRequirements();
    }

    /**
     * Retrieve a list of dependencies set in the 'dependencies' config.
     *
     * @return Collection
     */
    private function getConfigDependencies(): Collection
    {
        // Convert array of dependency type keys & array of dependency values
        // to a flat array of dependency keys and type values
        return collect(config('dependencies.dependencies'))
            ->mapWithKeys(function ($packages, $type) {
                return collect($packages)
                    ->mapWithKeys(function (string $package) use ($type) {
                        return [$package => $type];
                    });
            });
    }

    /**
     * Retrieve an array of composer packages that are required by the composer.json.
     *
     * @return Collection
     */
    private static function getComposerRequirements(): Collection
    {
        // Retrieve 'require' array from composer.json with only package names (the keys
        return collect(array_keys(
                json_decode(file_get_contents(base_path('composer.json')), true)['require'])
            )

            // Remove 'php' & php extensions from the packages array
            ->filter(function (string $dep) {
                return $dep != 'php' && ! (new StringHelpers($dep))->inString('ext');
            })

            // Map each dependencies to have a 'composer' value
            ->mapWithKeys(function (string $dep) {
                return [$dep => 'composer'];
            });
    }
}
